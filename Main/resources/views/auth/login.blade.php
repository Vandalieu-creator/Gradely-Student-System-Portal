<x-guest-layout>

    <!-- Heading -->
    <div class="text-center mb-8">

        @if(request('role') === 'teacher')

            <h1 class="text-3xl font-semibold text-slate-800">
                Teacher Login
            </h1>

            <p class="text-sm text-slate-700 mt-2">
                Sign in to your teacher account
            </p>

        @else

            <h1 class="text-3xl font-semibold text-slate-800">
                Student Login
            </h1>

            <p class="text-sm text-slate-700 mt-2">
                Sign in to your student account
            </p>

        @endif

    </div>


    <!-- Session Status -->
    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />


    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">

        @csrf


        <!-- Email / Username -->
        <div>

            <label
                for="email"
                class="block text-sm font-medium text-slate-700 mb-2"
            >
                Email or Username
            </label>

            <input
                id="email"
                type="text"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"

                class="w-full px-4 py-3
                       rounded-xl
                       border border-white/60
                       bg-white/50
                       backdrop-blur-sm
                       text-slate-800
                       placeholder-slate-500
                       shadow-sm
                       focus:outline-none
                       focus:ring-2
                       focus:ring-teal-500
                       focus:border-transparent"
            >

            @if($errors->get('email'))

                <p class="mt-2 text-sm text-red-600">
                    {{ $errors->first('email') }}
                </p>

            @endif

        </div>


        <!-- Password -->
        <div class="mt-5">

            <label
                for="password"
                class="block text-sm font-medium text-slate-700 mb-2"
            >
                Password
            </label>

            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"

                class="w-full px-4 py-3
                       rounded-xl
                       border border-white/60
                       bg-white/50
                       backdrop-blur-sm
                       text-slate-800
                       shadow-sm
                       focus:outline-none
                       focus:ring-2
                       focus:ring-teal-500
                       focus:border-transparent"
            >

            @if($errors->get('password'))

                <p class="mt-2 text-sm text-red-600">
                    {{ $errors->first('password') }}
                </p>

            @endif

        </div>


        <!-- Remember Me -->
        <div class="mt-5 flex items-center">

            <input
                id="remember_me"
                type="checkbox"
                name="remember"

                class="w-4 h-4
                       rounded
                       border-gray-300
                       text-teal-600
                       focus:ring-teal-500"
            >

            <label
                for="remember_me"
                class="ml-2 text-sm text-slate-700"
            >
                Remember me
            </label>

        </div>


        <!-- Login Button -->
        <div class="mt-7">

            <button
                type="submit"

                class="w-full py-3.5
                       bg-teal-600
                       hover:bg-teal-700
                       text-white
                       font-medium
                       rounded-xl
                       shadow-lg
                       hover:shadow-xl
                       transition-all
                       duration-200"
            >
                Log In
            </button>

        </div>


        <!-- Bottom Links -->
        <div class="mt-6 text-center">

            @if (Route::has('password.request'))

                <a
                    href="{{ route('password.request') }}"
                    class="text-sm text-slate-700
                           hover:text-slate-900
                           underline"
                >
                    Forgot your password?
                </a>

            @endif


            <!-- Register -->
            <div class="mt-3">

                <a
                    href="{{ route('register', ['role' => request('role', 'student')]) }}"

                    class="text-sm
                           text-teal-700
                           hover:text-teal-900
                           font-medium
                           underline"
                >
                    Register now
                </a>

            </div>

        </div>

    </form>

</x-guest-layout>