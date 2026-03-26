# Sistema de Captura de Calificaciones (Laravel + Livewire)

Sistema web con 3 roles (Coordinador, Maestro y Alumno) para gestión de materias, asignaciones, inscripciones, captura y consulta de calificaciones.
Construido con Laravel, Livewire y componentes de Flux.

## Características

- Autenticación
- Roles y permisos:
    - Coordinador: CRUD de usuarios(Maestro y Alumno) y materias, asignar materias a los maestros e inscribir alumnos
    - Maestro: capturar calificaciones y notas en cada materia asignada
    - Alumno: consulta de sus calificaciones y notas
- Relacionamiento con llaves foráneas (materias, asignaciones, inscripciones, calificaciones)
- Captura por parciales (P1, P2, P3) y Final, con notas y estado actual
- Dashboard personalizado según rol

## Usuarios de ejemplo (seed)

Se crean 3 usuarios base:

- Coordinador
    - Email: `coord@example.com`
    - Password: `password`
- Maestro
    - Email: `maestro@example.com`
    - Password: `password`
- Alumno
    - Email: `alumno@example.com`
    - Password: `password`

Además, se inserta la materia `MAT101`, se asigna al maestro y se inscribe al alumno.

## Flujo por rol

- Coordinador:
    - Materias: crear/editar/eliminar
    - Usuarios: crear/editar/eliminar
    - Asignaciones: maestro ↔ materia
    - Inscripciones: alumno ↔ materia
- Maestro:
    - Selecciona una materia asignada y captura Parcial 1, Parcial 2, Parcial 3 y Final incluyendo una nota
- Alumno:
    - Ver listado de materias inscritas y sus calificaciones

## Estructura de datos

- users: incluye columna `role` (`alumno`, `maestro`, `coordinador`)
- subjects: catálogo de materias
- teacher_subjects: asignaciones maestro-materia
- enrollments: inscripciones alumno-materia
- grades: calificaciones por inscripción y asignación (P1, P2, P3, Final, notas, status)

## Notas

- El registro asigna por defecto el rol de Coordinador
- De ser necesario se puede editar o deshabilitar el registro público

## Despliegue en Railway (Docker)

Este repositorio ya incluye:

- `Dockerfile` para producción
- `.dockerignore`
- `docker/start.sh` para levantar app, ejecutar migraciones y seeders
- `.env.railway.example` con variables listas para copiar en Railway

### 1) Crear servicios en Railway

- Servicio web desde este repositorio (usando Dockerfile)
- Servicio PostgreSQL en el mismo proyecto

### 2) Variables de entorno

Copiar el contenido de `.env.railway.example` al panel de Variables del servicio web y ajustar:

- `APP_URL` con el dominio real de Railway
- `APP_KEY` (puedes generarla local con `php artisan key:generate --show`)
- `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` con los datos del servicio PostgreSQL

### 3) Migraciones y datos demo

Al iniciar el contenedor, `docker/start.sh` ejecuta:

- `php artisan migrate --force`
- `php artisan db:seed --force`

Esto se controla con:

- `RUN_MIGRATIONS=true`
- `RUN_DB_SEED=true`

El seeder es idempotente: puedes redeployar sin errores por duplicados.

### 4) Usuarios demo listos

- Coordinador: `coord@example.com` / `password`
- Maestro: `maestro@example.com` / `password`
- Alumno: `alumno@example.com` / `password`

Se crea además:

- Materia `MAT101`
- Asignación del maestro a la materia
- Inscripción del alumno
- Calificaciones de ejemplo (P1, P2, P3, Final) para mostrar flujo completo
