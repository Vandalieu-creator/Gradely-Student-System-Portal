<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-teal-300 via-sky-400 to-pink-200">

    <div class="min-h-screen flex items-center justify-center">

        <div class="bg-white/40 backdrop-blur-md border border-white/50
                    shadow-2xl rounded-3xl p-10 text-center">

            <h1 class="text-4xl font-bold text-slate-800">
                Welcome, {{ auth()->user()->name }}! 💗
            </h1>

            <p class="mt-3 text-slate-700">
                Welcome to your Student Dashboard.
            </p>

            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf

                <button
                    type="submit"
                    class="px-6 py-3 bg-teal-600 hover:bg-teal-700
                           text-white font-semibold rounded-xl
                           shadow-lg transition"
                >
                    Log Out
                </button>
            </form>

        </div>

    </div>

</body>
</html>