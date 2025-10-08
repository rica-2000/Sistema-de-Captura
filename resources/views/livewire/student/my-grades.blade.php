<div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
            <thead class="bg-neutral-50 dark:bg-neutral-800">
                <tr>
                    <th class="px-4 py-2 text-left">Materia</th>
                    <th class="px-4 py-2 text-left">Calificación</th>
                    <th class="px-4 py-2 text-left">Estatus</th>
                    <th class="px-4 py-2 text-left">Notas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $r)
                    <tr class="border-t border-neutral-200 dark:border-neutral-700">
                        <td class="px-4 py-2">{{ $r->subject->name }}</td>
                        <td class="px-4 py-2">{{ optional($r->grade)->score }}</td>
                        <td class="px-4 py-2">{{ optional($r->grade)->status ?? 'pendiente' }}</td>
                        <td class="px-4 py-2">{{ optional($r->grade)->notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
