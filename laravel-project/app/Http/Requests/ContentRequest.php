<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
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
            "thoughts" => "max:300",
            'food_img' => [
                'file',
                'mimes:jpg,jpeg,png',
                'max:10240'
            ],
            'shop_img' => [
                'file',
                'mimes:jpg,jpeg,png',
                'max:10240'
            ]
        ];
    }
}
