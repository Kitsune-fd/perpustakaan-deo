<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobHistoryRequest extends FormRequest
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
            'teacher_id' => [Rule::requiredIf($this->isMethod('post')), 'exists:teachers,id'],
            'company_name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'start_year' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'end_year' => ['nullable', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'file_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'teacher_id.required' => 'ID guru wajib diisi.',
            'teacher_id.exists' => 'Guru tidak ditemukan.',
            'company_name.required' => 'Nama perusahaan wajib diisi.',
            'company_name.string' => 'Nama perusahaan harus berupa teks.',
            'company_name.max' => 'Nama perusahaan maksimal 255 karakter.',
            'position.string' => 'Posisi harus berupa teks.',
            'position.max' => 'Posisi maksimal 255 karakter.',
            'start_year.required' => 'Tahun mulai wajib diisi.',
            'start_year.digits' => 'Tahun mulai harus terdiri dari 4 digit.',
            'start_year.integer' => 'Tahun mulai harus berupa angka.',
            'start_year.min' => 'Tahun mulai minimal adalah 1900.',
            'start_year.max' => 'Tahun mulai tidak boleh lebih dari tahun saat ini.',
            'end_year.digits' => 'Tahun selesai harus terdiri dari 4 digit.',
            'end_year.integer' => 'Tahun selesai harus berupa angka.',
            'end_year.min' => 'Tahun selesai minimal adalah 1900.',
            'end_year.max' => 'Tahun selesai tidak boleh lebih dari tahun saat ini.',
            'file_path.file' => 'Dokumen harus berupa file yang valid.',
            'file_path.mimes' => 'Dokumen harus berformat PDF.',
            'file_path.max' => 'Ukuran dokumen maksimal adalah 2MB.',
        ];
    }
}
