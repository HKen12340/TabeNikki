<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
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
            "food_name" => "required|max:100",
            "shop_name" => "required|max:100",
            "price" => "required|min:0",
            "visit_date" => "required",
            "place" => "required|max:100",
            "thoughts" => "max:300"
        ];
    }
}
