<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gradely Student System Portal') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen bg-gradient-to-br from-teal-300 via-sky-400 to-pink-200 flex items-center justify-center font-sans">

    <!-- Main Glass Card -->
    <div class="bg-white/30 backdrop-blur-md border border-white/40 shadow-2xl rounded-3xl p-10 max-w-md w-full mx-4">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="/"
               class="inline-flex items-center gap-2 px-4 py-2
                      bg-white/40 hover:bg-white/60
                      backdrop-blur-sm
                      border border-white/50
                      rounded-xl
                      text-sm font-medium text-slate-700
                      shadow-sm hover:shadow-md
                      transition-all duration-200">

                <!-- Arrow Icon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-4 h-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15 19l-7-7 7-7" />
                </svg>

                Back to Home
            </a>
        </div>

        <!-- Login / Register Content -->
        {{ $slot }}

    </div>

</body>

</html>