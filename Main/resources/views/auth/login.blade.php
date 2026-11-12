
<x-guest-layout>

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
            <h1 class="text-2xl font-bold text-[#2C4156]">
                Student Login 🎒
            </h1>

            <p class="text-xs text-[#5B7894] mt-1 font-medium">
                Enter your 12-digit Learner Reference Number (LRN)
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="hidden" name="login_type" value="student">

            <!-- LRN -->
            <div>
                <label for="lrn"
                       class="block text-xs font-bold text-[#2C4156] mb-1.5 uppercase tracking-wider">
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
                    <p class="mt-2 text-xs font-bold text-red-600 text-center">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Student Password -->
            <div class="mt-4">
                <label for="student_password"
                       class="block text-xs font-bold text-[#2C4156] mb-1.5 uppercase tracking-wider">
                    Password
                </label>

                <input
                    id="student_password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    class="w-full px-4 py-3 rounded-xl border border-white/80 bg-white/80 text-[#2C4156] placeholder-gray-400 font-bold focus:outline-none focus:ring-2 focus:ring-[#3B8276] shadow-inner"
                >

                @error('password')
                    <p class="mt-2 text-xs font-bold text-red-600 text-center">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Student Login Button -->
            <div class="mt-6">
                <button
                    type="submit"
                    class="w-full py-3.5 bg-[#3B8276] hover:bg-[#2F6B61] text-white font-bold rounded-xl shadow-md transition cursor-pointer"
                >
                    Enter Dashboard
                </button>
            </div>
        </form>

    @elseif(request('role') === 'teacher')
        <!-- TEACHER LOGIN FORM -->

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2C4156]">
                Teacher Login 👩‍🏫
            </h1>

            <p class="text-xs text-[#5B7894] mt-1 font-medium">
                Sign in with your Employee ID and Password
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="hidden" name="login_type" value="teacher">

            <div class="space-y-4">
                <!-- Employee ID -->
                <div>
                    <label for="employee_id"
                           class="block text-xs font-bold text-[#2C4156] mb-1">
                        Employee ID
                    </label>

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
                        <p class="mt-1 text-xs font-bold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Teacher Password -->
                <div>
                    <label for="password"
                           class="block text-xs font-bold text-[#2C4156] mb-1">
                        Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                        class="w-full px-4 py-3 rounded-xl border border-white/80 bg-white/80 text-[#2C4156] placeholder-gray-400 font-bold focus:outline-none focus:ring-2 focus:ring-[#3B82B6] shadow-inner"
                    >

                    @error('password')
                        <p class="mt-1 text-xs font-bold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Teacher Login Button -->
            <div class="mt-6">
                <button
                    type="submit"
                    class="w-full py-3.5 bg-[#3B82B6] hover:bg-[#2D6A94] text-white font-bold rounded-xl shadow-md transition cursor-pointer"
                >
                    Log In
                </button>
            </div>
        </form>
    @endif

</x-guest-layout>
