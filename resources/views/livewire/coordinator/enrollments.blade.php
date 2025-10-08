<div class="space-y-6">
        <div class="max-w-xl">
            <form wire:submit.prevent="enroll" class="flex gap-3">
                <flux:select wire:model.defer="student_id" class="w-64" label="Alumno">
                    <option value="">Seleccione</option>
                    @foreach($students as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                    @endforeach
                </flux:select>
                <flux:select wire:model.defer="subject_id" class="w-64" label="Materia">
                    <option value="">Seleccione</option>
                    @foreach($subjects as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </flux:select>
                <flux:button type="submit">Inscribir</flux:button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-4 py-2 text-left">Alumno</th>
                        <th class="px-4 py-2 text-left">Materia</th>
                        <th class="px-4 py-2 text-left w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $r)
                        <tr class="border-t border-neutral-200 dark:border-neutral-700">
                            <td class="px-4 py-2">{{ $r->student->name }}</td>
                            <td class="px-4 py-2">{{ $r->subject->name }}</td>
                            <td class="px-4 py-2">
                                <flux:button size="xs" color="red" wire:click="delete({{ $r->id }})">Eliminar</flux:button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
