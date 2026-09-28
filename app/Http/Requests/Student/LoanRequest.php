<?php

namespace App\Http\Requests\Student;

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
            'book_id' => 'required|exists:books,id',
            'loaned_date' => 'required|date|after_or_equal:today',
            'due_date' => 'required|date|after:loaned_date',
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => 'Book ID is required.',
            'book_id.exists' => 'The selected book does not exist.',
            'loaned_date.required' => 'Loaned date is required.',
            'loaned_date.date' => 'Loaned date must be a valid date.',
            'loaned_date.after_or_equal' => 'Loaned date must be today or a future date.',
            'due_date.required' => 'Due date is required.',
            'due_date.date' => 'Due date must be a valid date.',
            'due_date.after' => 'Due date must be after the loaned date.',
        ];
    }
}
