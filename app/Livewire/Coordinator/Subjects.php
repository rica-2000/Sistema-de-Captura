<?php

namespace App\Livewire\Coordinator;

use App\Models\Subject;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Subjects extends Component
{
    public string $name = '';
    public string $code = '';
    public string $description = '';
    public ?int $subjectId = null;

    public function render()
    {
        return view('livewire.coordinator.subjects', [
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required', 'string', 'max:50',
                Rule::unique('subjects', 'code')->ignore($this->subjectId),
            ],
            'description' => ['nullable', 'string'],
        ]);

        Subject::updateOrCreate(
            ['id' => $this->subjectId],
            ['name' => $this->name, 'code' => $this->code, 'description' => $this->description]
        );

        $this->reset(['name', 'code', 'description', 'subjectId']);
        session()->flash('status', 'Materia guardada.');
    }

    public function edit(int $id)
    {
        $s = Subject::findOrFail($id);
        $this->subjectId = $s->id;
        $this->name = $s->name;
        $this->code = $s->code;
        $this->description = (string)($s->description ?? '');
    }

    public function delete(int $id)
    {
        Subject::findOrFail($id)->delete();
        session()->flash('status', 'Materia eliminada.');
    }
}
