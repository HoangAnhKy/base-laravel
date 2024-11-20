<?php

namespace App\Imports;

use App\Http\Requests\StoreCourseDetailRequest;
use App\Models\CourseDetail;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToArray;

class CourseDetailImport implements ToArray
{

    protected $errors = [];

    public function array(array $array)
    {
        $course_id = 2;
        for($i = 5; $i < count($array); $i += 1){
            $student = Users::selectOne(["name_user" => $array[$i][0]])->id ?? null;
            if (!empty($student)){
                $data = [
                    "course_id" => $course_id,
                    "student_id" => $student,
                    "create_by" => auth()->id()
                ];
                $request = new StoreCourseDetailRequest();
                $request->merge($data);

                $rules = $request->rules();

                $validator = Validator::make($data, $rules);

                if ($validator->fails()) {
                    $this->errors[] = [
                        'row' => $i + 1,
                        'data' => $array[$i],
                        'errors' => $validator->errors()->toArray(),
                    ];
                    continue;
                }
                CourseDetail::saveDB($data);
            }
        }
    }
    public function getErrors()
    {
        return $this->errors;
    }
}
