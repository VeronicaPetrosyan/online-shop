<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSearchProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'created_at' => 'nullable|date_format:Y-m-d',
            'updated_at' => 'nullable|date_format:Y-m-d',
        ];
    }
}
