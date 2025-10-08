<?php

namespace App\Livewire\Coordinator;

use App\Models\TeacherSubject;
use App\Models\Subject;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Assignments extends Component
{
    public ?int $teacher_id = null;
    public ?int $subject_id = null;

    public function render()
    {
        return view('livewire.coordinator.assignments', [
            'teachers' => User::where('role','maestro')->orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'rows' => TeacherSubject::with('teacher','subject')->get(),
        ]);
    }

    public function assign()
    {
        $data = $this->validate([
            'teacher_id' => ['required', 'exists:users,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
        ]);

        TeacherSubject::firstOrCreate($data);
        $this->reset(['teacher_id','subject_id']);
    }

    public function delete(int $id)
    {
        TeacherSubject::findOrFail($id)->delete();
    }
}
