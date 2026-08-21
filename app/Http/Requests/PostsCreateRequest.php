<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsCreateRequest extends FormRequest
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
}