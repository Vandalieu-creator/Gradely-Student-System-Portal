<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ginatilan Elementary School Portal</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-teal-300 via-sky-400 to-pink-200 min-h-screen flex items-center justify-center font-sans">

    <!-- Main Card Wrapper -->
    <div class="bg-white/30 backdrop-blur-md border border-white/40 shadow-2xl rounded-3xl p-8 sm:p-12 text-center max-w-md w-full mx-4 my-8">
        
        <!-- School Logo and Name Header -->
        <div class="flex flex-col items-center mb-6">
            <div class="relative mb-3">
                <img 
                    src="https://scontent.fcgy1-3.fna.fbcdn.net/v/t39.30808-6/306785656_399144949050859_6940190266702559829_n.jpg?stp=dst-jpg_tt6&cstp=mx828x826&ctp=s828x826&_nc_cat=107&_nc_map=urlgen_bucketless&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeF9qZjwNm8ws90wGeOqub0Eo6zNz6rPh_OjrM3Pqs-H8wS5n8vDVhoVtTSS4_xuRAJgS26g3wgxBi6xKpoNHqQ5&_nc_ohc=FW-j_FEzrbcQ7kNvwEwT63b&_nc_oc=AdrKR7rNle1H8gKGVImclHZmMCgu58CsqQTjszwsTg1EfbYrGyXL7wR3C1jQ81nAnu0&_nc_zt=23&_nc_ht=scontent.fcgy1-3.fna&_nc_gid=sIjMlVk-b2AmePncb3Dw0A&_nc_ss=7b2a8&oh=00_AQMDhpAOFSUOYgN6PLYNdW2XC2g2FOQwICPTaKPcFaF_LQ&oe=6AD7D0A2" 
                    alt="Ginatilan Elementary School Logo" 
                    class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover bg-white ring-4 ring-teal-500/20"
                >
            </div>
            <h2 class="text-xl font-bold text-slate-800 tracking-wide uppercase">
                Ginatilan Elementary School
            </h2>
            <span class="text-xs font-semibold text-teal-800 tracking-widest uppercase mt-0.5">
                School Portal
            </span>
        </div>

        <!-- Welcome Message -->
        <h1 class="text-2xl sm:text-3xl font-light text-slate-800 mb-8 tracking-wide">
            Welcome, Students and Teachers!
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