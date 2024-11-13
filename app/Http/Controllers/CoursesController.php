<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseDetailRequest;
use App\Jobs\registerCouser;
use App\Library\CourseLibrary;
use App\Library\UserLibrary;
use App\Models\CourseDetail;
use App\Models\Courses;
use App\Http\Requests\StoreCoursesRequest;
use App\Http\Requests\UpdateCoursesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rule;

class CoursesController extends Controller
{
    private $lib_course;
    private $lib_user;

    public function __construct()
    {
        $this->lib_course = new CourseLibrary();

        $this->lib_user = new UserLibrary();
    }

    public function index()
    {
        $list_filter = $this->lib_course->getFilter();
        $list_search = $this->lib_course->getSearch();
        $condition = [];
        $contain = ["teacher"];

        $teachers = $this->lib_user->selectPosition();
        $students = $this->lib_user->selectPosition(STUDENT);

        $courses = Courses::paginateForPage($condition, $list_filter, $list_search, $contain);
        return view("Course.index", compact("courses", "teachers", "students"));
    }

    public function create()
    {
        $teachers = $this->lib_user->selectPosition();
        return view("Course.create", compact("teachers"));
    }

    public function store(StoreCoursesRequest $request)
    {
        if ($request->getMethod() === POST && Courses::saveDB($request->validated())) {
            return redirect()->route("courses.index")->with("success", "Save Course success");
        }
        return redirect()->route("courses.create")->with("error", "Cannot save Course");
    }

    public function edit($course = null)
    {
        if (isset($course) && is_numeric($course)) {
            $teachers = $this->lib_user->selectPosition();
            $course = Courses::selectOne([["id", $course]]);
            return view("Course.edit", compact("teachers", "course"));
        }
        return redirect()->route("courses.index")->with("error", "Cannot find Course");
    }

    public function update(UpdateCoursesRequest $request, $course = null)
    {
        if (isset($course) && is_numeric($course) && $request->getMethod() === PUT && Courses::updateDB(["id" => $course], $request->validated())) {
            return redirect()->route("courses.index")->with("success", "Update Course success");
        }
        return redirect()->route("users.index")->with("error", "Cannot find this user");
    }

    public function delete(Request $request, $course = null)
    {
        if ($this->lib_course->delete($request, $course)) {
            return redirect()->route("courses.index")->with("success", "Delete Course success");
        }
        return redirect()->route("courses.index")->with("error", "Cannot find Course");
    }


    public function register($course = null, StoreCourseDetailRequest $request){
        if (isset($course) && is_numeric($course)) {

            try {

                $lockKey = "register_course_lock_{$course}_{$request["student_id"]}";

                $lock = Redis::set($lockKey, true, 'EX', 60, 'NX');

                if (!$lock) {
                    return redirect()->route("courses.index")->with("error", "Cannot register course ");
                }

                registerCouser::dispatch($request->validated())->delay(now()->addMinutes(1));
                return redirect()->route("courses.index")->with("success", "Register Course success");
            } catch (\Exception $e) {
                return redirect()->route("courses.index")->with("error", "Cannot register course: " . $e->getMessage());
            }

        }
        return redirect()->route("courses.index")->with("error", "Cannot find Course");
    }

    public function checkStudentInCourse(Request $request){
        return $this->lib_course->checkStudentInCourse($request);
    }

    public function viewDetail($course = null){
        if (isset($course) && is_numeric($course)) {
            $condition = [["id", $course]];
            $contain = ["teacher", "student"];
            $course_detail = Courses::selectOne($condition, $contain);
            $student = $course_detail->student()->paginate(LIMIT);
            return view("Course.viewDetail", compact("course_detail", "student"));
        }
        return redirect()->route("courses.index")->with("error", "Cannot find Course");
    }

}
