<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSearchReviewRequest extends FormRequest
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
            'comment' => 'nullable|string|max:255',
            'created_at' => 'nullable|date_format:Y-m-d',
            'updated_at' => 'nullable|date_format:Y-m-d',
        ];
    }
}
