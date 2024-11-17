<?php

namespace App\Library;

use App\Events\MyEvent;
use App\Models\CourseDetail;
use App\Models\Courses;
use App\Models\notification;
use App\Models\Users;
use Illuminate\Validation\Rule;

class CourseLibrary
{
    public function getFilter()
    {
        $filter = [];

        if (isset($_GET["teacher_search"]) && $_GET["teacher_search"] !== "-1") {
            $filter["CONTAIN"]["teacher"] = ["id", $_GET["teacher_search"]];
        }

        return $filter;
    }

    public function getSearch()
    {
        $search = [];
        if (!empty($_GET["key_search"])) {
            $key_search = $_GET["key_search"];
            $search["AND"] = [
            ];
            $search["OR"] = [
                ["courses.name_course", "like", "%$key_search%"]
            ];
        }
        return $search;
    }

    public function delete($request, $course = null)
    {
        if (isset($course) && is_numeric($course)) {

            $request->merge([
                "course_id" => $course,
                "del_flag" => DEL,
                "status" => INACTIVE
            ]);

            $validate = $request->validate([
                "course_id" => [Rule::exists(Courses::class, "id")],
                "del_flag" => [Rule::in([DEL])],
                "status" => [Rule::in([INACTIVE])],
            ]);

            unset($validate["course_id"]);

            if (Courses::updateDB(["id" => $course], $validate)) {
                return true;
            }
        }
        return false;
    }

    public function checkStudentInCourse($request)
    {
        $status = false;
        if ($request->ajax()) {
            $student_id = $request->get("student_id");
            $course_id = $request->get("course_id");

            $course_detail = CourseDetail::selectOne(
                [
                    ["student_id", $student_id],
                    ["course_id", $course_id]
                ]);

            $status = empty($course_detail);
        }
        return response()->json($status);
    }

    public function registerCourse($data, $userID, $teacherID)
    {
        CourseDetail::saveDB($data);
        $user = Users::find($userID);

        if ($user->id !== $teacherID) {
            $message = $user->name_user . " join course";

            $db_notification = [
                "messenger" => $message,
                "user_id" => $teacherID,
                "link" => BASE_URL . "/course/course-detail/1",
            ];

            notification::saveDB($db_notification);

            event(new MyEvent($message, $teacherID));
        }
    }

}
