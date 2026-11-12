
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gradely | Ginatilan Elementary School</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
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

    <style>
        body {
            background: linear-gradient(
                135deg,
                #43d5c5 0%,
                #38bdf8 50%,
                #e9c9ee 100%
            );
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.28);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.55);
            box-shadow: 0 25px 60px rgba(15, 75, 110, 0.15);
        }

        .portal-card {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.9);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .portal-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(15, 75, 110, 0.15);
        }

        .portal-image {
            height: 125px;
            width: 100%;
            object-fit: contain;
            object-position: center;
        }

        @media (max-height: 750px) and (min-width: 768px) {
            .portal-image {
                height: 100px;
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center font-sans px-4 py-3">

    <!-- Main Glass Card -->
    <main class="glass-card w-full max-w-4xl rounded-[2rem] p-5 sm:p-7 lg:p-8">

        <!-- School Branding -->
        <header class="text-center mb-4">

            <!-- School Logo -->
            <div class="flex justify-center mb-3">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden flex items-center justify-center">
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

        <!-- Welcome Message -->
        <section class="text-center mb-5">

            <h2 class="font-display text-2xl sm:text-3xl lg:text-4xl font-semibold text-slate-800 mb-1">
                Welcome to Gradely!
            </h2>

            <p class="text-slate-700 text-sm sm:text-base">
                Your school, your learning, your progress.
            </p>

        </section>

        <!-- Portal Selection -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-5">

            <!-- Student Portal -->
            <article class="portal-card rounded-3xl p-4 flex flex-col text-center">

                <div class="flex items-center justify-center mb-2">
                    <img
                        src="{{ asset('images/student-illustration.png') }}"
                        alt="Student carrying a school backpack"
                        class="portal-image"
                    >
                </div>

                <h3 class="font-display text-xl sm:text-2xl font-semibold text-teal-800 mb-1">
                    Student Portal
                </h3>

                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    View your grades, attendance, and school updates.
                </p>

                <a
                    href="{{ route('login', ['role' => 'student']) }}"
                    class="mt-auto block w-full py-3 px-4 bg-teal-600 hover:bg-teal-700 text-white text-sm sm:text-base font-bold rounded-xl shadow-md transition duration-200 hover:shadow-lg"
                >
                    Student Login
                    <span class="ml-1">→</span>
                </a>

            </article>

            <!-- Teacher Portal -->
            <article class="portal-card rounded-3xl p-4 flex flex-col text-center">

                <div class="flex items-center justify-center mb-2">
                    <img
                        src="{{ asset('images/teacher-illustration.png') }}"
                        alt="Teacher holding a clipboard"
                        class="portal-image"
                    >
                </div>

                <h3 class="font-display text-xl sm:text-2xl font-semibold text-sky-800 mb-1">
                    Teacher Portal
                </h3>

                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Manage classes, student records, and progress.
                </p>

                <a
                    href="{{ route('login', ['role' => 'teacher']) }}"
                    class="mt-auto block w-full py-3 px-4 bg-sky-600 hover:bg-sky-700 text-white text-sm sm:text-base font-bold rounded-xl shadow-md transition duration-200 hover:shadow-lg"
                >
                    Teacher Login
                    <span class="ml-1">→</span>
                </a>

            </article>

        </section>

        <!-- Footer -->
        <footer class="text-center mt-4">
            <p class="text-slate-700/80 text-xs">
                Ginatilan Elementary School · Gradely Portal
            </p>
        </footer>

    </main>

</body>
</html>
