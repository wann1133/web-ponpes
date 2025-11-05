<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogPostRequest extends FormRequest
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
        $blogPostId = $this->route('blog_post')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blog_posts', 'slug')->ignore($blogPostId),
            ],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:150'],
            'author' => ['nullable', 'string', 'max:150'],
            'reading_time' => ['nullable', 'string', 'max:50'],
            'external_url' => ['nullable', 'url'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'remove_thumbnail' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->has('is_published') ? $this->boolean('is_published') : false,
            'is_featured' => $this->has('is_featured') ? $this->boolean('is_featured') : false,
            'remove_thumbnail' => $this->boolean('remove_thumbnail'),
        ]);
    }
}
