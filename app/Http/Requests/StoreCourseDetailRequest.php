<?php

namespace App\Http\Requests;

use App\Models\CourseDetail;
use App\Models\Courses;
use App\Models\Users;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreCourseDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $data_request = [
            "course_id" => $this->course,
            "create_by" => Auth::id()
        ];

        if (!$this->has("student_id")){
            $data_request["student_id"] = Auth::id();
        }

        $this->merge($data_request);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $course_id = $this->course;
        return [
            "course_id" => [Rule::exists(Courses::class, "id")],
            "student_id" => [
                Rule::exists(Users::class, "id"),
                Rule::unique('course_details')
                ->where(function ($query) use ($course_id) {
                    return $query->where('course_id', $course_id);
                }),
            ],
            "create_by" =>  [
                Rule::exists(Users::class, "id")
            ]
        ];
    }
}
