<x-guest-layout>

    <!-- School Logo & Title Header -->
    <div class="flex flex-col items-center justify-center text-center mb-6">
        <img 
            src="https://scontent.fcgy1-3.fna.fbcdn.net/v/t39.30808-6/306785656_399144949050859_6940190266702559829_n.jpg?stp=dst-jpg_tt6&cstp=mx828x826&ctp=s828x826&_nc_cat=107&_nc_map=urlgen_bucketless&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeF9qZjwNm8ws90wGeOqub0Eo6zNz6rPh_OjrM3Pqs-H8wS5n8vDVhoVtTSS4_xuRAJgS26g3wgxBi6xKpoNHqQ5&_nc_ohc=FW-j_FEzrbcQ7kNvwEwT63b&_nc_oc=AdrKR7rNle1H8gKGVImclHZmMCgu58CsqQTjszwsTg1EfbYrGyXL7wR3C1jQ81nAnu0&_nc_zt=23&_nc_ht=scontent.fcgy1-3.fna&_nc_gid=sIjMlVk-b2AmePncb3Dw0A&_nc_ss=7b2a8&oh=00_AQMDhpAOFSUOYgN6PLYNdW2XC2g2FOQwICPTaKPcFaF_LQ&oe=6AD7D0A2" 
            alt="Ginatilan Elementary School Logo" 
            class="w-20 h-20 rounded-full border-4 border-white shadow-md object-cover bg-white mb-2"
        >
        <h2 class="text-xl font-extrabold text-[#2C4156] tracking-tight">
            GINATILAN ELEMENTARY SCHOOL
        </h2>
        <span class="text-xs font-semibold text-[#5B7894] tracking-widest uppercase">
            SCHOOL PORTAL
        </span>
    </div>

    @if(!request()->has('role'))
        <!-- LANDING SCREEN -->
        <div class="text-center my-6">
            <h1 class="text-2xl font-bold text-[#2C4156]">
                Welcome, Students and Teachers!
            </h1>
        </div>

        <div class="space-y-3.5 mt-6">
            <a href="{{ route('login', ['role' => 'student']) }}" 
               class="w-full py-3.5 px-4 bg-[#3B8276] hover:bg-[#2F6B61] text-white font-bold text-center block rounded-xl shadow-md transition">
                Sign in as Student
            </a>

            <a href="{{ route('login', ['role' => 'teacher']) }}" 
               class="w-full py-3.5 px-4 bg-[#3B82B6] hover:bg-[#2D6A94] text-white font-bold text-center block rounded-xl shadow-md transition">
                Sign in as Teacher
            </a>

            <a href="/" 
               class="w-full py-3 px-4 bg-white/70 hover:bg-white/90 text-[#4A5568] font-semibold text-center block rounded-xl border border-white/80 shadow-xs transition">
                Exit
            </a>
        </div>

    @elseif(request('role') === 'student')
        <!-- STUDENT LOGIN FORM -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2C4156]">Student Login 🎒</h1>
            <p class="text-xs text-[#5B7894] mt-1 font-medium">Enter your 12-digit Learner Reference Number (LRN)</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="login_type" value="student">

            <div>
                <label for="lrn" class="block text-xs font-bold text-[#2C4156] mb-1.5 uppercase tracking-wider">
                    Learner Reference Number (LRN)
                </label>
                <input
                    id="lrn"
                    type="text"
                    name="lrn"
                    value="{{ old('lrn') }}"
                    required
                    autofocus
                    maxlength="12"
                    placeholder="109876543210"
                    class="w-full px-4 py-3 rounded-xl border border-white/80 bg-white/80 text-[#2C4156] placeholder-gray-400 font-bold text-center text-lg tracking-widest focus:outline-none focus:ring-2 focus:ring-[#3B8276] shadow-inner"
                >
                @error('lrn')
                    <p class="mt-2 text-xs font-bold text-red-600 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full py-3.5 bg-[#3B8276] hover:bg-[#2F6B61] text-white font-bold rounded-xl shadow-md transition cursor-pointer">
                    Enter Dashboard
                </button>
            </div>
        </form>

    @elseif(request('role') === 'teacher')
        <!-- TEACHER LOGIN FORM -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2C4156]">Teacher Login 👩‍🏫</h1>
            <p class="text-xs text-[#5B7894] mt-1 font-medium">Sign in with your Employee ID and Password</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="login_type" value="teacher">

            <div class="space-y-4">
                <div>
                    <label for="employee_id" class="block text-xs font-bold text-[#2C4156] mb-1">Employee ID</label>
                    <input 
                        id="employee_id" 
                        type="text" 
                        name="employee_id" 
                        value="{{ old('employee_id') }}" 
                        required 
                        autofocus 
                        placeholder="EMP-2026-001"
                        class="w-full px-4 py-3 rounded-xl border border-white/80 bg-white/80 text-[#2C4156] placeholder-gray-400 font-bold focus:outline-none focus:ring-2 focus:ring-[#3B82B6] shadow-inner"
                    >
                    @error('employee_id')
                        <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-[#2C4156] mb-1">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full px-4 py-3 rounded-xl border border-white/80 bg-white/80 text-[#2C4156] placeholder-gray-400 font-bold focus:outline-none focus:ring-2 focus:ring-[#3B82B6] shadow-inner"
                    >
                    @error('password')
                        <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full py-3.5 bg-[#3B82B6] hover:bg-[#2D6A94] text-white font-bold rounded-xl shadow-md transition cursor-pointer">
                    Log In
                </button>
            </div>
        </form>
    @endif

</x-guest-layout>