<?php

namespace App\Http\Requests;

use App\Models\Courses;
use App\Models\Users;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use function Symfony\Component\String\u;

class UpdateCoursesRequest extends FormRequest
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
        $this->merge(["course_id" => $this->course]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "course_id" => [Rule::exists(Courses::class, "id")],
            "name_course" => ["bail", "required", "string", Rule::unique(Courses::class, "name_course")->ignore($this->course)],
            "teacher_id" => ["bail", "required",
                Rule::exists(Users::class, "id")->where(function ($query) {
                    $query->where('status', ACTIVE)
                        ->where('position', TEACHER);
                })
            ],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validate =  parent::validated($key, $default);
        unset($validate["course_id"]);
        return $validate;
    }
}
