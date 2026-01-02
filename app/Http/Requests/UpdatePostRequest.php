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
            'judul'       => 'required|string|min:5|max:200',
            'ringkasan'   => 'required|string|min:10',
            'konten'      => 'required|string|min:50',


            'kategori_id' => 'required|exists:categories,id',

            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}

