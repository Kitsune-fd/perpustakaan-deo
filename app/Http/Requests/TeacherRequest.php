<?php

namespace App\Http\Requests;

use App\Enums\Education;
use App\Enums\Subject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:20', 'unique:teachers,nip,' . $this->teacher?->id],
            'subject' => ['required', Rule::in(Subject::getValues())],
            'last_education' => ['required', Rule::in(Education::getValues())],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'nip' => 'NIP',
            'subject' => 'Mata Pelajaran',
            'last_education' => 'Pendidikan Terakhir',
            'birthdate' => 'Tanggal Lahir',
            'gender' => 'Jenis Kelamin',
            'address' => 'Alamat',
            'is_active' => 'Status Aktif',
        ];

    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa string.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'unique' => ':attribute sudah digunakan.',
            'date' => ':attribute bukan tanggal yang valid.',
            'in' => ':attribute yang dipilih tidak valid.',
            'boolean' => ':attribute harus berupa true atau false.',
        ];
    }
}
