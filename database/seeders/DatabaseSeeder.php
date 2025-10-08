<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\TeacherSubject;
use App\Models\Enrollment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuarios base
        $coordinador = User::factory()->create([
            'name' => 'Carmen Coordinadora',
            'email' => 'coord@example.com',
            'role' => 'coordinador',
        ]);

        $maestro = User::factory()->create([
            'name' => 'Mario Maestro',
            'email' => 'maestro@example.com',
            'role' => 'maestro',
        ]);

        $alumno = User::factory()->create([
            'name' => 'Ana Alumna',
            'email' => 'alumno@example.com',
            'role' => 'alumno',
        ]);

        // Materia ejemplo
        $mat = Subject::create([
            'name' => 'Matemáticas I',
            'code' => 'MAT101',
            'description' => 'Curso básico de matemáticas.',
        ]);

        // Asignar maestro a materia
        $ts = TeacherSubject::create([
            'teacher_id' => $maestro->id,
            'subject_id' => $mat->id,
        ]);

        // Inscribir alumno a materia
        Enrollment::create([
            'student_id' => $alumno->id,
            'subject_id' => $mat->id,
        ]);
    }
}
