<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gradely Student System Portal</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-teal-300 via-sky-400 to-pink-200 h-screen flex items-center justify-center font-sans">

    <!-- Main Card Wrapper -->
    <div class="bg-white/30 backdrop-blur-md border border-white/40 shadow-2xl rounded-3xl p-12 text-center max-w-md w-full mx-4">
        
        <!-- Welcome Message -->
        <h1 class="text-4xl font-light text-slate-800 mb-10 tracking-wide">
            Welcome, Student and Teacher!
        </h1>

        <!-- Buttons Container -->
        <div class="space-y-4">
            <!-- Sign in as Student Button -> Goes to Login -->
            <a href="{{ route('login', ['role' => 'student']) }}" class="block w-full py-3.5 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-xl shadow-lg transition duration-200 text-center">
                Sign in as Student
            </a>

            <!-- Sign in as Teacher Button -> Goes to Login -->
            <a href="{{ route('login', ['role' => 'teacher']) }}" class="block w-full py-3.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-xl shadow-lg transition duration-200 text-center">
                Sign in as Teacher
            </a>

            <!-- Exit Button -->
            <button onclick="window.close();" class="block w-full py-3.5 bg-white/60 hover:bg-white/80 text-slate-700 font-medium rounded-xl shadow-md transition duration-200 text-center">
                Exit
            </button>
        </div>

    </div>

</body>
</html>