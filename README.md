# Examen 2 — Sistema de Captura de Calificaciones (Laravel + Livewire)

Sistema web con 3 roles (Coordinador, Maestro y Alumno) para gestión de materias, asignaciones, inscripciones, captura y consulta de calificaciones.
Construido con Laravel, Livewire y componentes de Flux.

## Características

-   Autenticación
-   Roles y permisos:
    -   Coordinador: CRUD de usuarios(Maestro y Alumno) y materias, asignar materias a los maestros e inscribir alumnos
    -   Maestro: capturar calificaciones y notas en cada materia asignada
    -   Alumno: consulta de sus calificaciones y notas
-   Relacionamiento con llaves foráneas (materias, asignaciones, inscripciones, calificaciones)
-   Captura por parciales (P1, P2, P3) y Final, con notas y estado actual
-   Dashboard personalizado según rol

## Usuarios de ejemplo (seed)

Se crean 3 usuarios base:

-   Coordinador
    -   Email: `coord@example.com`
    -   Password: `password`
-   Maestro
    -   Email: `maestro@example.com`
    -   Password: `password`
-   Alumno
    -   Email: `alumno@example.com`
    -   Password: `password`

Además, se inserta la materia `MAT101`, se asigna al maestro y se inscribe al alumno.

## Flujo por rol

-   Coordinador:
    -   Materias: crear/editar/eliminar
    -   Usuarios: crear/editar/eliminar
    -   Asignaciones: maestro ↔ materia
    -   Inscripciones: alumno ↔ materia
-   Maestro:
    -   Selecciona una materia asignada y captura Parcial 1, Parcial 2, Parcial 3 y Final incluyendo una nota
-   Alumno:
    -   Ver listado de materias inscritas y sus calificaciones

## Estructura de datos

-   users: incluye columna `role` (`alumno`, `maestro`, `coordinador`)
-   subjects: catálogo de materias
-   teacher_subjects: asignaciones maestro-materia
-   enrollments: inscripciones alumno-materia
-   grades: calificaciones por inscripción y asignación (P1, P2, P3, Final, notas, status)

## Notas

-   El registro asigna por defecto el rol de Coordinador
-   De ser necesario se puede editar o deshabilita el registro público
