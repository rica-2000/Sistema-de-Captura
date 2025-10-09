<x-layouts.app :title="__('Dashboard')">
    <div class="space-y-6">
        @php($user = auth()->user())
        @php($roleLabel = $user->isCoordinador() ? 'Coordinador' : ($user->isMaestro() ? 'Maestro' : 'Alumno'))

        <div class="rounded-xl border border-blue-200 bg-blue-50 text-blue-900 dark:border-blue-700 dark:bg-blue-900/30 dark:text-blue-200 px-4 py-3">
            <div class="text-lg font-semibold">Hola, {{ $user->name }} 👋</div>
            <div class="text-sm opacity-90">Bienvenido a tu plataforma — Rol: {{ $roleLabel }}</div>
        </div>

        @if($user->isCoordinador())
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <div class="text-sm text-neutral-500">Usuarios</div>
                    <div class="text-3xl font-semibold">{{ \App\Models\User::count() }}</div>
                </div>
                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <div class="text-sm text-neutral-500">Materias</div>
                    <div class="text-3xl font-semibold">{{ \App\Models\Subject::count() }}</div>
                </div>
                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <div class="text-sm text-neutral-500">Inscripciones</div>
                    <div class="text-3xl font-semibold">{{ \App\Models\Enrollment::count() }}</div>
                </div>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('coordinator.users') }}" class="px-4 py-2 rounded-md bg-blue-600 text-white">Gestionar usuarios</a>
                <a href="{{ route('coordinator.subjects') }}" class="px-4 py-2 rounded-md bg-emerald-600 text-white">Gestionar materias</a>
                <a href="{{ route('coordinator.assignments') }}" class="px-4 py-2 rounded-md bg-purple-600 text-white">Asignar maestros</a>
                <a href="{{ route('coordinator.enrollments') }}" class="px-4 py-2 rounded-md bg-amber-600 text-white">Inscribir alumnos</a>
            </div>
        @elseif($user->isMaestro())
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <div class="text-sm text-neutral-500">Materias asignadas</div>
                    <div class="text-3xl font-semibold">{{ \App\Models\TeacherSubject::where('teacher_id',$user->id)->count() }}</div>
                </div>
                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <div class="text-sm text-neutral-500">Alumnos a evaluar</div>
                    <div class="text-3xl font-semibold">{{ \App\Models\Enrollment::whereIn('subject_id', \App\Models\TeacherSubject::where('teacher_id',$user->id)->pluck('subject_id'))->count() }}</div>
                </div>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('teacher.grades') }}" class="px-4 py-2 rounded-md bg-blue-600 text-white">Capturar calificaciones</a>
            </div>
        @elseif($user->isAlumno())
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <div class="text-sm text-neutral-500">Materias inscritas</div>
                    <div class="text-3xl font-semibold">{{ \App\Models\Enrollment::where('student_id',$user->id)->count() }}</div>
                </div>
                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <div class="text-sm text-neutral-500">Calificaciones capturadas</div>
                    <div class="text-3xl font-semibold">{{ \App\Models\Grade::whereIn('enrollment_id', \App\Models\Enrollment::where('student_id',$user->id)->pluck('id'))->where('status','capturada')->count() }}</div>
                </div>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('student.my-grades') }}" class="px-4 py-2 rounded-md bg-blue-600 text-white">Ver mis calificaciones</a>
            </div>
        @endif
    </div>
</x-layouts.app>
