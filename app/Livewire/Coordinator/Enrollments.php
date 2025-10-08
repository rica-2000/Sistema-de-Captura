<?php

namespace App\Livewire\Coordinator;

use App\Models\Enrollment;
use App\Models\Subject;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Enrollments extends Component
{
    public ?int $student_id = null;
    public ?int $subject_id = null;

    public function render()
    {
        return view('livewire.coordinator.enrollments', [
            'students' => User::where('role','alumno')->orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'rows' => Enrollment::with('student','subject')->get(),
        ]);
    }

    public function enroll()
    {
        $data = $this->validate([
            'student_id' => ['required', 'exists:users,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
        ]);

        Enrollment::firstOrCreate($data);
        $this->reset(['student_id','subject_id']);
    }

    public function delete(int $id)
    {
        Enrollment::findOrFail($id)->delete();
    }
}
