<?php

namespace App\Livewire\Teacher;

use App\Models\Enrollment;
use App\Models\Grade as GradeModel;
use App\Models\TeacherSubject;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Grades extends Component
{
    public $teacher_subject_id = null;
    public array $scores = [];

    public function mount(): void
    {
        $first = TeacherSubject::where('teacher_id', auth()->id())
            ->orderBy('id')
            ->first();
        if ($first) {
            $this->teacher_subject_id = (int) $first->id;
        }
    }

    public function render()
    {
        $teacherSubjects = TeacherSubject::with('subject')
            ->where('teacher_id', auth()->id())
            ->get();

        $enrollments = collect();
        $authorized = false;
        if ($this->teacher_subject_id) {
            $ts = TeacherSubject::with('subject')->find($this->teacher_subject_id);
            if ($ts && $ts->teacher_id === auth()->id()) {
                $authorized = true;
                $enrollments = Enrollment::with(['student','grade' => function($q) use ($ts){
                    $q->where('teacher_subject_id', $ts->id);
                }])->where('subject_id', $ts->subject_id)->get();

                foreach ($enrollments as $en) {
                    if (!array_key_exists($en->id, $this->scores)) {
                        $this->scores[$en->id] = [
                            'p1' => optional($en->grade)->p1,
                            'p2' => optional($en->grade)->p2,
                            'p3' => optional($en->grade)->p3,
                            'final' => optional($en->grade)->final,
                            'notes' => optional($en->grade)->notes,
                        ];
                    }
                }
            }
        }

        return view('livewire.teacher.grades', compact('teacherSubjects','enrollments','authorized'));
    }

    public function save()
    {
        $ts = TeacherSubject::findOrFail($this->teacher_subject_id);
        abort_if($ts->teacher_id !== auth()->id(), 403);

        foreach ($this->scores as $enrollmentId => $row) {
            $p1 = isset($row['p1']) && $row['p1'] !== '' ? (float) $row['p1'] : null;
            $p2 = isset($row['p2']) && $row['p2'] !== '' ? (float) $row['p2'] : null;
            $p3 = isset($row['p3']) && $row['p3'] !== '' ? (float) $row['p3'] : null;
            $final = isset($row['final']) && $row['final'] !== '' ? (float) $row['final'] : null;
            $notes = $row['notes'] ?? null;

            $enrollment = Enrollment::find($enrollmentId);
            if (!$enrollment || $enrollment->subject_id !== $ts->subject_id) {
                continue;
            }

            // Determinar status: capturada si hay al menos un valor
            $hasAny = $p1 !== null || $p2 !== null || $p3 !== null || $final !== null;
            GradeModel::updateOrCreate(
                ['enrollment_id' => $enrollment->id, 'teacher_subject_id' => $ts->id],
                ['p1' => $p1, 'p2' => $p2, 'p3' => $p3, 'final' => $final, 'status' => $hasAny ? 'capturada' : 'pendiente', 'notes' => $notes]
            );
        }

        session()->flash('status', 'Calificaciones guardadas.');
    }

    public function updatedTeacherSubjectId($value): void
    {
        $this->teacher_subject_id = $value !== '' ? (int) $value : null;
        $this->scores = [];
        $this->resetErrorBag();
    }

    public function subjectChanged(): void
    {
        if ($this->teacher_subject_id !== null) {
            $this->teacher_subject_id = (int) $this->teacher_subject_id;
        }
        $this->scores = [];
    }
}
