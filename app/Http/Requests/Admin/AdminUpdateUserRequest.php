<?php

namespace App\Http\Requests\Admin;

use App\Traits\FetchRequestError;
use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateUserRequest extends FormRequest
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
            'account_id' => 'required|exists:users,id',
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email',
            'password' => 'string|min:8',
            'gender' => 'boolean',
            'nationalid' => 'string|size:14',
            'phone' => 'string|size:11|unique:users,phone',
            'credit_points' => 'integer',
            'semester' => 'in:first,second',
            'type' => 'boolean',
            'department_id' => 'exists:departments,id',
            'level_id' => 'exists:levels,id',
            'job_title' => 'min:3|max:50'
        ];
    }
}
