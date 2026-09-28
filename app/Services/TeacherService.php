<?php
namespace App\Services;

use App\DTO\LetterDTO;
use App\DTO\TeacherDTO;
use App\Enums\DirectionLetter;
use App\Models\File;
use App\Models\Guru;
use App\Models\Letter;
use App\Models\Siswa;
use App\Models\Teacher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\ErrorHandler\Collecting;

class TeacherService
{
    public function store(TeacherDTO $teacher): Teacher
    {   
        $teacher = Teacher::create([
            'name' => $teacher->name,
            'nip' => $teacher->nip,
            'subject' => $teacher->subject,
            'last_education' => $teacher->lastEducation,
            'birthdate' => $teacher->birthdate,
            'gender' => $teacher->gender,
            'address' => $teacher->address,
            'is_active' => $teacher->isActive ?? true,
        ]);

        return $teacher;
    }

    public function storeDocument(Teacher $teacher, array $documentData): Teacher
    {   
        foreach ($documentData as $document) {
            app(FileService::class)->upload($document, $teacher);
        }

        return $teacher->load('files');
    }

    public function update(Teacher $teacher, TeacherDTO $teacherDTO): Teacher
    {
        $teacher->update([
            'name' => $teacherDTO->name,
            'nip' => $teacherDTO->nip,
            'subject' => $teacherDTO->subject,
            'last_education' => $teacherDTO->lastEducation,
            'birthdate' => $teacherDTO->birthdate,
            'gender' => $teacherDTO->gender,
            'address' => $teacherDTO->address,
            'is_active' => $teacherDTO->isActive,
        ]); 
        return $teacher;
    }
}
