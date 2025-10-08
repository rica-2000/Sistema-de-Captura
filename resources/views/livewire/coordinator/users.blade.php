<div class="space-y-6">
        <div class="max-w-xl">
            <form wire:submit.prevent="save" class="space-y-3">
                <flux:input label="Nombre" wire:model.defer="name" />
                <flux:input type="email" label="Email" wire:model.defer="email" />
                <flux:select label="Rol" wire:model.defer="role">
                    <option value="alumno">Alumno</option>
                    <option value="maestro">Maestro</option>
                    <option value="coordinador">Coordinador</option>
                </flux:select>
                <flux:input type="password" label="Password" wire:model.defer="password" placeholder="{{ $userId ? 'Dejar en blanco para mantener' : '' }}" />
                <flux:button type="submit">Guardar</flux:button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Rol</th>
                        <th class="px-4 py-2 text-left w-40">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr class="border-t border-neutral-200 dark:border-neutral-700">
                            <td class="px-4 py-2">{{ $u->name }}</td>
                            <td class="px-4 py-2">{{ $u->email }}</td>
                            <td class="px-4 py-2">{{ ucfirst($u->role) }}</td>
                            <td class="px-4 py-2">
                                <div class="flex gap-2">
                                    <flux:button size="xs" wire:click="edit({{ $u->id }})">Editar</flux:button>
                                    <flux:button size="xs" color="red" wire:click="delete({{ $u->id }})">Eliminar</flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
