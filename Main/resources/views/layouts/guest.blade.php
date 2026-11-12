
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gradely | Ginatilan Elementary School Portal</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Fredoka', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-gradient-to-br from-teal-300 via-sky-400 to-pink-200 flex items-center justify-center font-sans px-4 py-6">

    <!-- Main Glass Card -->
    <main class="relative isolate overflow-hidden bg-white/30 backdrop-blur-md border border-white/50 shadow-2xl rounded-3xl p-6 sm:p-8 max-w-md w-full mx-auto">

        <!-- Faded Background Illustration -->
        <img
            src="{{ asset('images/login-card-background.png') }}"
            alt=""
            aria-hidden="true"
            class="absolute inset-0 w-full h-full object-cover opacity-25 pointer-events-none"
        >

        <!-- Soft Overlay for Readability -->
        <div class="absolute inset-0 bg-white/35 pointer-events-none"></div>

        <!-- Card Content -->
        <div class="relative z-10">

            <!-- Back to Home -->
            <div class="mb-5">
                <a href="/"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/40 hover:bg-white/60 backdrop-blur-sm border border-white/50 rounded-xl text-sm font-semibold text-slate-700 shadow-sm hover:shadow-md transition-all duration-200">

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

                    Back to Portal Home
                </a>
            </div>

            <!-- School Branding -->
            <header class="text-center mb-6">

                <div class="flex justify-center mb-3">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden flex items-center justify-center">
                        <img
                            src="{{ asset('images/school-logo2.png') }}"
                            alt="Ginatilan Elementary School Logo"
                            class="w-full h-full object-contain"
                        >
                    </div>
                </div>

                <h1 class="font-display text-lg sm:text-xl font-bold tracking-wide uppercase text-slate-800">
                    Ginatilan Elementary School
                </h1>

                <p class="text-xs font-bold tracking-[0.25em] uppercase text-teal-800 mt-1">
                    School Portal
                </p>

            </header>

            <!-- Login Form Content -->
            {{ $slot }}

            <!-- Footer -->
            <footer class="text-center mt-6 pt-4 border-t border-white/30">
                <p class="text-xs text-slate-600">
                    Ginatilan Elementary School · Gradely Portal
                </p>
            </footer>

        </div>

    </main>

</body>
</html>
