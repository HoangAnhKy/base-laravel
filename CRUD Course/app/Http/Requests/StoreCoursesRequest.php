<?php

namespace App\Http\Requests;

use App\Models\Courses;
use App\Models\Users;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCoursesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name_course" => ["bail", "required", "string", Rule::unique(Courses::class, "name_course")],
            "teacher_id" => ["bail", "required",
                Rule::exists(Users::class, "id")->where(function ($query) {
                    $query->where('status', ACTIVE)
                        ->where('position', TEACHER);
                })
            ],
        ];
    }
}
