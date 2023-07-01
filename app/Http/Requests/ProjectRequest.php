<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id'   => 'nullable|integer',
            'team_id'       => 'nullable|integer',

            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'priority'      => 'integer',
            'deadline'      => 'date',
        ];
    }
}
