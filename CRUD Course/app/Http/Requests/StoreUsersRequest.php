<?php

namespace App\Http\Requests;

use App\Models\Users;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class  StoreUsersRequest extends FormRequest
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
            "name_user" => [ "bail", "string", "required", Rule::unique(Users::class, "name_user")->where("status", ACTIVE)->where("del_flag", UNDEL) ],
            "email" => ["bail", "string", "required", Rule::unique(Users::class, "email")->where("status", ACTIVE)->where("del_flag", UNDEL) ],
            "birthdate" => ["bail", "required", "date_format:Y-m-d"],
            "position" => ["bail", "required", "in:" . implode(",", array_keys(LIST_POSITION))]
        ];
    }
}
