<?php

namespace App\Livewire\Student;

use App\Models\Enrollment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class MyGrades extends Component
{
    public function render()
    {
        $rows = Enrollment::with(['subject', 'grade'])
            ->where('student_id', auth()->id())
            ->get();

        return view('livewire.student.my-grades', compact('rows'));
    }
}
