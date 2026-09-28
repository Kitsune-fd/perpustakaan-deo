<?php

namespace App\Http\Requests;

use App\Enums\Subject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeachingHistoryRequest extends FormRequest
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
            'subject' => ['required', Rule::in(Subject::getValues())],
            'grade_level' => ['required', Rule::in(\App\Enums\GradeLevel::getValues())],
            'start_year' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'end_year' => ['nullable', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
        ];
    }

    public function messages(): array
    {
        return [
            'teacher_id.required' => 'ID guru wajib diisi.',
            'teacher_id.exists' => 'Guru tidak ditemukan.',
            'subject.required' => 'Mata pelajaran wajib diisi.',
            'subject.in' => 'Mata pelajaran tidak valid.',
            'grade_level.required' => 'Tingkatan wajib diisi.',
            'grade_level.in' => 'Tingkatan tidak valid.',
            'start_year.required' => 'Tahun mulai wajib diisi.',
            'start_year.digits' => 'Tahun mulai harus terdiri dari 4 digit.',
            'start_year.integer' => 'Tahun mulai harus berupa angka.',
            'start_year.min' => 'Tahun mulai minimal adalah 1900.',
            'start_year.max' => 'Tahun mulai tidak boleh lebih dari tahun saat ini.',
            'end_year.digits' => 'Tahun selesai harus terdiri dari 4 digit.',
            'end_year.integer' => 'Tahun selesai harus berupa angka.',
            'end_year.min' => 'Tahun selesai minimal adalah 1900.',
            'end_year.max' => 'Tahun selesai tidak boleh lebih dari tahun saat ini.',
        ];
    }
}
