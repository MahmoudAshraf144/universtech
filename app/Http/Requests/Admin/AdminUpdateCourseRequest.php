<?php

namespace App\Http\Requests\Admin;

use App\Traits\FetchRequestError;
use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateCourseRequest extends FormRequest
{
    use FetchRequestError;
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'course_name' => 'string|max:255',
            'no_of_hours' => 'integer|min:1',
            'course_code' => 'string|max:255|unique:courses,course_code',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'department_id' => 'exists:departments,id',
            'professor_id' => 'exists:users,id'
        ];
    }
}
