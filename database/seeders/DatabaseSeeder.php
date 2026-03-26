<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\TeacherSubject;
use App\Models\Enrollment;
use App\Models\Grade;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $defaultPassword = Hash::make('password');

        // Usuarios demo (idempotente para redeploys)
        $coordinador = User::updateOrCreate([
            'email' => 'coord@example.com',
        ], [
            'name' => 'Carmen Coordinadora',
            'password' => $defaultPassword,
            'role' => 'coordinador',
        ]);

        $maestro = User::updateOrCreate([
            'email' => 'maestro@example.com',
        ], [
            'name' => 'Mario Maestro',
            'password' => $defaultPassword,
            'role' => 'maestro',
        ]);

        $alumno = User::updateOrCreate([
            'email' => 'alumno@example.com',
        ], [
            'name' => 'Ana Alumna',
            'password' => $defaultPassword,
            'role' => 'alumno',
        ]);

        // Materia demo
        $mat = Subject::updateOrCreate([
            'code' => 'MAT101',
        ], [
            'name' => 'Matemáticas I',
            'description' => 'Curso básico de matemáticas.',
        ]);

        // Asignar maestro a materia
        $ts = TeacherSubject::updateOrCreate([
            'teacher_id' => $maestro->id,
            'subject_id' => $mat->id,
        ]);

        // Inscribir alumno a materia
        $enrollment = Enrollment::updateOrCreate([
            'student_id' => $alumno->id,
            'subject_id' => $mat->id,
        ]);

        // Calificaciones demo para visualizar la app al iniciar
        Grade::updateOrCreate(
            [
                'enrollment_id' => $enrollment->id,
                'teacher_subject_id' => $ts->id,
            ],
            [
                'p1' => 8.5,
                'p2' => 9.0,
                'p3' => 8.8,
                'final' => 9.1,
                'status' => 'capturada',
                'notes' => 'Rendimiento constante durante el curso.',
            ]
        );
    }
}
