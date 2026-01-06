<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'gambar'       => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'       => 'Judul wajib diisi.',
            'ringkasan.required'   => 'Ringkasan wajib diisi.',
            'konten.required'      => 'Konten wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists'   => 'Kategori tidak valid.',
            'image.required'       => 'Gambar wajib diupload.',
            'image.image'          => 'File harus berupa gambar.',
            'image.mimes'          => 'Format gambar harus jpg/jpeg/png/webp.',
            'image.max'            => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
