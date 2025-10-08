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
                            'score' => optional($en->grade)->score,
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
            $score = isset($row['score']) && $row['score'] !== '' ? (float) $row['score'] : null;
            $notes = $row['notes'] ?? null;

            $enrollment = Enrollment::find($enrollmentId);
            if (!$enrollment || $enrollment->subject_id !== $ts->subject_id) {
                continue;
            }

            GradeModel::updateOrCreate(
                ['enrollment_id' => $enrollment->id, 'teacher_subject_id' => $ts->id],
                ['score' => $score, 'status' => is_null($score) ? 'pendiente' : 'capturada', 'notes' => $notes]
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
