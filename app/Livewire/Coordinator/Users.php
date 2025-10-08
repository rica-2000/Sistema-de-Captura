<?php

namespace App\Livewire\Coordinator;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Users extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'alumno';
    public ?int $userId = null;

    public function render()
    {
        return view('livewire.coordinator.users', [
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'role' => ['required', Rule::in(['alumno','maestro','coordinador'])],
            'password' => [$this->userId ? 'nullable' : 'required', 'min:6'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        User::updateOrCreate(['id' => $this->userId], $data);
        $this->reset(['name','email','password','role','userId']);
        session()->flash('status', 'Usuario guardado.');
    }

    public function edit(int $id)
    {
        $u = User::findOrFail($id);
        $this->userId = $u->id;
        $this->name = $u->name;
        $this->email = $u->email;
        $this->role = $u->role;
    }

    public function delete(int $id)
    {
        User::findOrFail($id)->delete();
    }
}
