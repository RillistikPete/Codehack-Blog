<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UsersEditRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'email', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'role_id'   => 'required|exists:roles,id',
            'is_active' => 'required|in:0,1',
            'password'  => 'nullable|min:8|confirmed',
            'photo_id'  => 'nullable|image|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'photo_id.uploaded' => 'The image is too large to upload. Please choose a file under 5 MB.',
            'photo_id.max'      => 'The image must be smaller than 5 MB.',
        ];
    }

    public function attributes(): array
    {
        return ['photo_id' => 'photo'];
    }
}
