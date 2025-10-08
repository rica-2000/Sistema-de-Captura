<div class="space-y-6">
        <div class="max-w-lg flex items-end gap-3">
            <div class="w-80">
                <label class="block text-sm font-medium mb-1">Materia asignada</label>
                <select class="w-full border rounded-md px-3 py-2 bg-white text-black dark:bg-neutral-900 dark:text-neutral-100" wire:model.live="teacher_subject_id" wire:change="subjectChanged">
                    <option value="">Seleccione</option>
                    @foreach($teacherSubjects as $ts)
                        <option value="{{ $ts->id }}">{{ $ts->subject->name }}</option>
                    @endforeach
                </select>
            </div>
            @if($teacher_subject_id)
                <button type="button" wire:click="save" class="px-3 py-2 rounded-md bg-blue-600 text-white">Guardar</button>
            @endif
        </div>


        @if($teacher_subject_id)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden text-zinc-900 dark:text-zinc-100">
                    <thead class="bg-neutral-50 dark:bg-neutral-800 text-zinc-900 dark:text-zinc-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Alumno</th>
                            <th class="px-4 py-2 text-left">Calificación</th>
                            <th class="px-4 py-2 text-left">Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrollments as $en)
                            <tr class="border-t border-neutral-200 dark:border-neutral-700" wire:key="enrollment-{{ $en->id }}">
                                <td class="px-4 py-2">{{ $en->student->name }}</td>
                                <td class="px-4 py-2">
                                    <input type="number" step="0.01" min="0" max="100" class="w-28 border rounded-md px-2 py-1 bg-white text-black dark:bg-neutral-900 dark:text-neutral-100" wire:model.defer="scores.{{ $en->id }}.score">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" class="w-full border rounded-md px-2 py-1 bg-white text-black dark:bg-neutral-900 dark:text-neutral-100" wire:model.defer="scores.{{ $en->id }}.notes">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-neutral-500">No hay alumnos inscritos para esta materia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($authorized) && !$authorized)
                <div class="text-red-600 text-sm">No estás autorizado para capturar calificaciones de esta materia.</div>
            @endif
        @endif
    </div>
