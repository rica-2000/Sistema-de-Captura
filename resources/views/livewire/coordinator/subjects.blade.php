<div class="space-y-6">
        <div class="max-w-xl">
            <form wire:submit.prevent="save" class="space-y-3">
                <div>
                    <flux:input label="Nombre" wire:model.defer="name" />
                </div>
                <div>
                    <flux:input label="Código" wire:model.defer="code" />
                </div>
                <div>
                    <flux:textarea label="Descripción" wire:model.defer="description" />
                </div>
                <div class="flex gap-2">
                    <flux:button type="submit">{{ $subjectId ? 'Actualizar' : 'Crear' }}</flux:button>
                    @if($subjectId)
                        <flux:button color="neutral" wire:click="$set('subjectId', null); $set('name',''); $set('code',''); $set('description','')">Cancelar</flux:button>
                    @endif
                </div>
                @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
                @error('code')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Código</th>
                        <th class="px-4 py-2 text-left">Descripción</th>
                        <th class="px-4 py-2 text-left w-40">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $s)
                        <tr class="border-t border-neutral-200 dark:border-neutral-700">
                            <td class="px-4 py-2">{{ $s->name }}</td>
                            <td class="px-4 py-2">{{ $s->code }}</td>
                            <td class="px-4 py-2">{{ $s->description }}</td>
                            <td class="px-4 py-2">
                                <div class="flex gap-2">
                                    <flux:button size="xs" wire:click="edit({{ $s->id }})">Editar</flux:button>
                                    <flux:button size="xs" color="red" wire:click="delete({{ $s->id }})">Eliminar</flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
