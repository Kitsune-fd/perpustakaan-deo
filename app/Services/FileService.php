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

class FileService
{
    public function upload($documentData, Teacher $teacher): File
    {   
        $extension = $documentData['file']->getClientOriginalExtension();
        $timestamp = now()->format('YmdHis');
        $teacherName = Str::slug($teacher->name);
        $type = $documentData['type'];
        $fileName = $teacherName . '-' . $type . '-' . $timestamp . '.' . $extension;

        Storage::disk('public')->put('teacher_documents/' . $fileName, file_get_contents($documentData['file']->getRealPath()));
        
        $file = $teacher->files()->create([
            'document_type' => $documentData['type'],
            'description' => $documentData['description'] ?? null,
            'filename' => $fileName,
            'filepath' => 'teacher_documents/' . $fileName,
            'filetype' => $documentData['file']->getClientMimeType(),
            'filesize' => $documentData['file']->getSize(),
        ]);

        return $file;
    }
}
