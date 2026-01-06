<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'       => ['required', 'string', 'max:255'],
            'ringkasan'   => ['required', 'string'],
            'konten'      => ['required', 'string'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'gambar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
