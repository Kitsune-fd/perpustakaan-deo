<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
        return [
            'title' => ['required','string','max:255'],
            'author' => ['required','string','max:255'],
            'publisher' => ['required','string','max:255'],
            'year' => ['required','integer','digits:4'],
            'category_id' => ['required','exists:categories,id'],
            'shelf_id' => ['required','exists:shelves,id'],
            'stock_total' => ['required','integer','min:1'],
            'cover_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'description' => ['nullable','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Nama penulis wajib diisi.',
            'publisher.required' => 'Nama penerbit wajib diisi.',
            'year.required' => 'Tahun terbit wajib diisi.',
            'year.integer' => 'Tahun terbit harus berupa angka.',
            'year.digits' => 'Tahun terbit harus terdiri dari 4 digit.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'shelf_id.required' => 'Rak wajib dipilih.',
            'shelf_id.exists' => 'Rak yang dipilih tidak valid.',
            'stock_total.required' => 'Jumlah stok wajib diisi.',
            'stock_total.integer' => 'Jumlah stok harus berupa angka.',
            'stock_total.min' => 'Jumlah stok minimal adalah 1.',
            'cover_image.image' => 'File cover harus berupa gambar.',
            'cover_image.mimes' => 'File cover harus berformat jpeg, png, jpg, atau gif.',
            'cover_image.max' => 'Ukuran file cover maksimal adalah 2MB.',
        ];
    }
}
