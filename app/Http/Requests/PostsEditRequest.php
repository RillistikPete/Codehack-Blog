<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'body'        => 'required|string',
            'photo_id'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
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