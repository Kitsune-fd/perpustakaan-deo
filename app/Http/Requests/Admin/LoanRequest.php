<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
            'loaned_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:loaned_date'],
            'returned_date' => ['nullable', 'date', 'after_or_equal:loaned_date'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Pengguna wajib diisi.',
            'user_id.exists' => 'Pengguna tidak ditemukan.',
            'book_id.required' => 'Buku wajib diisi.',
            'book_id.exists' => 'Buku tidak ditemukan.',
            'loaned_date.required' => 'Tanggal pinjam wajib diisi.',
            'loaned_date.date' => 'Tanggal pinjam harus berupa tanggal yang valid.',
            'due_date.required' => 'Tanggal kembali wajib diisi.',
            'due_date.date' => 'Tanggal kembali harus berupa tanggal yang valid.',
            'due_date.after_or_equal' => 'Tanggal kembali harus sama dengan atau setelah tanggal pinjam.',
            'returned_date.date' => 'Tanggal kembali harus berupa tanggal yang valid.',
            'returned_date.after_or_equal' => 'Tanggal kembali harus sama dengan atau setelah tanggal pinjam.',
        ];
    }
}
