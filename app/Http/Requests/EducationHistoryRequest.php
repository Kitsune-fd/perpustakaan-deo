<?php

namespace App\Http\Requests;

use App\Enums\Education;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EducationHistoryRequest extends FormRequest
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
            'education' => ['required', Rule::enum(Education::class)],
            'institution_name' => ['required','string'],
            'degree_obtained' => ['nullable','string'],
            'graduation_year' => ['nullable','digits:4','integer'],
            'file_path' => ['nullable','file','mimes:pdf','max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'teacher_id.required' => 'ID Guru wajib diisi.',
            'teacher_id.exists' => 'ID Guru tidak valid.',
            'education.required' => 'Jenjang pendidikan wajib diisi.',
            'education.enum' => 'Jenjang pendidikan tidak valid.',
            'institution_name.required' => 'Nama institusi wajib diisi.',
            'institution_name.string' => 'Nama institusi harus berupa teks.',
            'degree_obtained.string' => 'Jurusan harus berupa teks.',
            'graduation_year.digits' => 'Tahun kelulusan harus terdiri dari 4 digit.',
            'graduation_year.integer' => 'Tahun kelulusan harus berupa angka.',
            'file_path.file' => 'Dokumen harus berupa file yang valid.',
            'file_path.mimes' => 'Dokumen harus berformat PDF.',
            'file_path.max' => 'Ukuran dokumen maksimal adalah 2MB.',
        ];
    }
}
