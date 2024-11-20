<?php

namespace App\Http\Controllers;

use App\Exports\CourseDetailErrorsExport;
use App\Exports\CourseDetailExport;
use App\Http\Requests\StoreCourseDetailRequest;
use App\Imports\CourseDetailImport;
use App\Jobs\registerCouser;
use App\Library\CourseLibrary;
use App\Library\NotificationLibrary;
use App\Library\UserLibrary;
use App\Models\CourseDetail;
use App\Models\Courses;
use App\Http\Requests\StoreCoursesRequest;
use App\Http\Requests\UpdateCoursesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class CoursesController extends Controller
{
    private $lib_course;
    private $lib_user;

    public function __construct()
    {
        parent::__construct();

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


    public function register($course = null, StoreCourseDetailRequest $request)
    {
        if (isset($course) && is_numeric($course)) {

            try {

                $teacher_id = Courses::selectOne(["id" => $course], [], ["teacher_id"])->teacher_id ?? null;
                $lockKey = "register_course_lock_{$course}_{$request["student_id"]}";

                $lock = Redis::set($lockKey, true, 'EX', 60, 'NX');

                if (!$lock) {
                    return redirect()->route("courses.index")->with("error", "Cannot register course ");
                }

//                registerCouser::dispatch($request->validated(), \auth()->id(), (int)$teacher_id)->delay(now()->addMinutes(1));
                registerCouser::dispatch($request->validated(), \auth()->id(), (int)$teacher_id);
                return redirect()->route("courses.index")->with("success", "Register Course success");
            } catch (\Exception $e) {
                return redirect()->route("courses.index")->with("error", "Cannot register course: " . $e->getMessage());
            }

        }
        return redirect()->route("courses.index")->with("error", "Cannot find Course");
    }

    public function checkStudentInCourse(Request $request)
    {
        return $this->lib_course->checkStudentInCourse($request);
    }

    public function viewDetail($course = null)
    {
        if (isset($course) && is_numeric($course)) {
            $condition = [["id", $course]];
            $contain = ["teacher", "student"];
            $course_detail = Courses::selectOne($condition, $contain);
            $student = $course_detail->student()->paginate(LIMIT);
            return view("Course.viewDetail", compact("course_detail", "student"));
        }
        return redirect()->route("courses.index")->with("error", "Cannot find Course");
    }

    public function APIReadnotification(Request $request)
    {
        $notification = new NotificationLibrary();

        $reponse = [
            "status" => 400,
            "link" => "",
            "messenger" => "Can not find this notification",
        ];

        if ($data = $notification->readNotification($request->all())) {

            $reponse = [
                "status" => 200,
                "link" => $data,
                "messenger" => "",
            ];
        }

        return response()->json($reponse, $reponse["status"]);
    }

    public function exportCourse($course)
    {
        if (isset($course) && is_numeric($course)) {

            $course = Courses::find($course);

            if (!empty($course)) {
                return Excel::download(new CourseDetailExport($course->id), "download course " . $course->name_course . '.xlsx');
            }

        }
        return redirect()->route("courses.index")->with("error", "Cannot find Course");
    }

    public function importCourse(Request $request)
    {
        if (!empty($file = $request->file("file-import"))){
            $import = new CourseDetailImport();
            Excel::import($import, $file);
            $error = $import->getErrors(); // dùng để trả về người dùng lỗi trong file import
            if (!empty($error)){
                $mess =  'Import success. But file have ' . count($error) . " errors";
                $filePath = 'temp/import_errors_' . time() . '.xlsx';
                Excel::store(new CourseDetailErrorsExport($error), $filePath, 'local');

                return redirect()->back()->with([
                    'success' => $mess,
                    'error_file' => $filePath,
                ]);
            }

            return redirect()->back()->with('success', 'Import success!');

        }
        return redirect()->back()->with("error", "Cannot import Course");
    }

    public function downloadErrorFile(Request $request)
    {
        $file = $request->get('file');

        if (Storage::exists($file)) {
            return response()->download(storage_path('app/private/' . $file))->deleteFileAfterSend(true);
        }

        return redirect()->back()->with('error', 'File not found.');
    }

}
