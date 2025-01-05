<?php

namespace App\Http\Requests;

use App\Models\Ideas;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateComment extends FormRequest
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
        if (!empty($this->idea_id)) {
            $this->merge(["idea_id" => $this->idea_id]);
        }

        return [
            "idea_id" => ["required", Rule::exists(Ideas::class, "id")],
            "content_comment_" . $this->idea_id => ["required", "min:1", "max:240"],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        foreach ($validated as $key => $value){
            unset($validated[$key]);
            $key = str_replace("_".$this->idea_id, "", $key);
            $validated[$key] = $value;
        }
        return $validated;
    }
}
