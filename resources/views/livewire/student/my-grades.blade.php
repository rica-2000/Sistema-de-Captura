<div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden text-zinc-900 dark:text-zinc-100">
            <thead class="bg-neutral-50 dark:bg-neutral-800 text-zinc-900 dark:text-zinc-100">
                <tr>
                    <th class="px-4 py-2 text-left">Materia</th>
                    <th class="px-4 py-2 text-left">P1</th>
                    <th class="px-4 py-2 text-left">P2</th>
                    <th class="px-4 py-2 text-left">P3</th>
                    <th class="px-4 py-2 text-left">Final</th>
                    <th class="px-4 py-2 text-left">Estatus</th>
                    <th class="px-4 py-2 text-left">Notas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $r)
                    <tr class="border-t border-neutral-200 dark:border-neutral-700">
                        <td class="px-4 py-2">{{ $r->subject->name }}</td>
                        <td class="px-4 py-2">{{ optional($r->grade)->p1 }}</td>
                        <td class="px-4 py-2">{{ optional($r->grade)->p2 }}</td>
                        <td class="px-4 py-2">{{ optional($r->grade)->p3 }}</td>
                        <td class="px-4 py-2">{{ optional($r->grade)->final }}</td>
                        <td class="px-4 py-2">{{ optional($r->grade)->status ?? 'pendiente' }}</td>
                        <td class="px-4 py-2">{{ optional($r->grade)->notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
