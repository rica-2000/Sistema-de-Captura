<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistema de Captura</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700,800|figtree:400,500,600" rel="stylesheet" />

    <style>
        :root {
            --ink: #102027;
            --ink-soft: #36515a;
            --paper: #f5f7ef;
            --brand: #ff6b35;
            --brand-strong: #de4f1f;
            --mint: #a7d8c9;
            --teal: #0f8b8d;
            --card: rgba(255, 255, 255, 0.75);
            --line: rgba(16, 32, 39, 0.14);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--ink);
            font-family: "Figtree", sans-serif;
            background:
                radial-gradient(1000px 500px at -10% -10%, #ffd8b8 0%, transparent 65%),
                radial-gradient(900px 500px at 110% 10%, #c5ece0 0%, transparent 62%),
                linear-gradient(125deg, #eff8f5 0%, #fef9f1 45%, #eef6ff 100%);
            position: relative;
            overflow-x: hidden;
        }

        .orb {
            position: fixed;
            border-radius: 999px;
            filter: blur(40px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.5;
            animation: float 9s ease-in-out infinite;
        }

        .orb.one {
            width: 240px;
            height: 240px;
            background: #ffb48e;
            top: 10%;
            left: -60px;
        }

        .orb.two {
            width: 280px;
            height: 280px;
            background: #8fd8d9;
            top: 60%;
            right: -100px;
            animation-delay: 1.8s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-18px) scale(1.03); }
        }

        .shell {
            position: relative;
            z-index: 1;
            max-width: 1120px;
            margin: 0 auto;
            padding: 28px 20px 48px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: "Space Grotesk", sans-serif;
            font-weight: 800;
            letter-spacing: 0.02em;
        }

        .brand-mark {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: conic-gradient(from 160deg, var(--brand), #ffbb58, var(--teal), var(--brand));
            box-shadow: 0 8px 24px rgba(15, 139, 141, 0.35);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            border: 1px solid var(--line);
            transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 32, 39, 0.12);
        }

        .btn.primary {
            background: var(--brand);
            color: #fff;
            border-color: transparent;
        }

        .btn.primary:hover {
            background: var(--brand-strong);
        }

        .btn.ghost {
            background: rgba(255, 255, 255, 0.65);
            color: var(--ink);
            backdrop-filter: blur(8px);
        }

        .hero {
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 26px;
            box-shadow: 0 20px 60px rgba(16, 32, 39, 0.1);
            padding: 30px;
            animation: reveal .6s ease both;
        }

        @keyframes reveal {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .eyebrow {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(15, 139, 141, 0.12);
            color: #0b5f61;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        h1 {
            margin: 16px 0 10px;
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(2rem, 5vw, 3.6rem);
            line-height: 1.05;
            letter-spacing: -0.02em;
            max-width: 12ch;
        }

        .lead {
            margin: 0;
            color: var(--ink-soft);
            max-width: 62ch;
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .grid {
            margin-top: 28px;
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 18px;
        }

        .card h2 {
            margin: 0 0 8px;
            font-family: "Space Grotesk", sans-serif;
            font-size: 1.05rem;
        }

        .card p {
            margin: 0;
            color: var(--ink-soft);
            line-height: 1.5;
            font-size: 0.95rem;
        }

        .stats {
            margin-top: 16px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .chip {
            padding: 9px 12px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px dashed rgba(16, 32, 39, 0.2);
            font-size: 0.9rem;
            color: var(--ink-soft);
        }

        .hero-cta {
            margin-top: 22px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .hero {
                padding: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="orb one"></div>
    <div class="orb two"></div>

    <div class="shell">
        <header class="topbar">
            <div class="brand">
                <span class="brand-mark" aria-hidden="true"></span>
                <span>Sistema de Captura</span>
            </div>

            @if (Route::has('login'))
                <nav class="actions" aria-label="Autenticacion">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn primary">Entrar al panel</a>
                    @else
                        <a href="{{ route('login') }}" class="btn ghost">Iniciar sesion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn primary">Crear cuenta</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="hero">
            <span class="eyebrow">Plataforma academica</span>
            <h1>Captura, organiza y publica notas sin friccion.</h1>
            <p class="lead">
                Centraliza materias, docentes, estudiantes y evaluaciones en un solo flujo.
                Disenada para coordinacion academica, control de inscripciones y registro de calificaciones parciales y finales.
            </p>

            <section class="grid" aria-label="Modulos principales">
                <article class="card">
                    <h2>Gestion de Materias</h2>
                    <p>Administra asignaturas y relaciona cada materia con sus docentes responsables.</p>
                </article>
                <article class="card">
                    <h2>Inscripciones y Grupos</h2>
                    <p>Controla estudiantes inscritos por materia y periodo con trazabilidad clara.</p>
                </article>
                <article class="card">
                    <h2>Captura de Notas</h2>
                    <p>Registra parciales, calcula resultados y mantiene un historial confiable.</p>
                </article>
            </section>

            <div class="stats" aria-label="Resumen rapido">
                <span class="chip">Roles: Coordinador, Docente, Estudiante</span>
                <span class="chip">Flujo seguro con autenticacion</span>
                <span class="chip">Diseño responsivo para desktop y movil</span>
            </div>

            <div class="hero-cta">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn primary">Ir al dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn primary">Comenzar ahora</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn ghost">Solicitar acceso</a>
                    @endif
                @endauth
            </div>
        </main>
    </div>
</body>
</html>
