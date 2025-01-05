<?php

namespace App\Http\Requests;

use App\Models\Users;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsersRequest extends FormRequest
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
        $this->merge(["user_id" => $this->route("user")]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => [Rule::exists(Users::class, "id")],
            "name_user" => [
                "bail",
                "string",
                "required",
                Rule::unique(Users::class, "name_user")->ignore($this->user)->where("status", ACTIVE)->where("del_flag", UNDEL)
            ],
            "email" => [
                "bail",
                "string",
                "required",
                "email",
                Rule::unique(Users::class, "email")->ignore($this->user)->where("status", ACTIVE)->where("del_flag", UNDEL)
            ],
            "birthdate" => [
                "bail",
                "required",
                "date_format:Y-m-d"
            ],
            "position" => [
                "bail",
                "required",
                Rule::in(array_keys(LIST_POSITION))
            ]
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validate =  parent::validated($key, $default);
        unset($validate["user_id"]);
        return $validate;
    }
}
