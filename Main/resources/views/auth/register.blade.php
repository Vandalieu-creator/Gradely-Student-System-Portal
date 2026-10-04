<x-guest-layout>

    <!-- Heading -->
    <div class="text-center mb-8">

        @if(request('role') === 'teacher')
            <h1 class="text-3xl font-semibold text-slate-800">
                Teacher Registration
            </h1>

            <p class="text-sm text-slate-700 mt-2">
                Create your teacher account
            </p>
        @else
            <h1 class="text-3xl font-semibold text-slate-800">
                Student Registration
            </h1>

            <p class="text-sm text-slate-700 mt-2">
                Create your student account
            </p>
        @endif

    </div>


    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Preserve Role -->
        <input
            type="hidden"
            name="role"
            value="{{ request('role', 'student') }}"
        >


        <!-- Name -->
        <div>
            <label
                for="name"
                class="block text-sm font-semibold text-slate-800 mb-2"
            >
                Name
            </label>

            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"

                class="w-full px-4 py-3
                       rounded-xl
                       border border-white/70
                       bg-white/70
                       backdrop-blur-sm
                       text-slate-800
                       placeholder-slate-500
                       shadow-sm
                       focus:outline-none
                       focus:ring-2
                       focus:ring-teal-500
                       focus:border-transparent"
            >

            @if($errors->get('name'))
                <p class="mt-2 text-sm text-red-700">
                    {{ $errors->first('name') }}
                </p>
            @endif
        </div>


        <!-- Username -->
        <div class="mt-5">
            <label
                for="username"
                class="block text-sm font-semibold text-slate-800 mb-2"
            >
                Username
            </label>

            <input
                id="username"
                type="text"
                name="username"
                value="{{ old('username') }}"
                required
                autocomplete="username"

                class="w-full px-4 py-3
                       rounded-xl
                       border border-white/70
                       bg-white/70
                       backdrop-blur-sm
                       text-slate-800
                       placeholder-slate-500
                       shadow-sm
                       focus:outline-none
                       focus:ring-2
                       focus:ring-teal-500
                       focus:border-transparent"
            >

            @if($errors->get('username'))
                <p class="mt-2 text-sm text-red-700">
                    {{ $errors->first('username') }}
                </p>
            @endif
        </div>


        <!-- Email -->
        <div class="mt-5">
            <label
                for="email"
                class="block text-sm font-semibold text-slate-800 mb-2"
            >
                Email
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"

                class="w-full px-4 py-3
                       rounded-xl
                       border border-white/70
                       bg-white/70
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
                <p class="mt-2 text-sm text-red-700">
                    {{ $errors->first('email') }}
                </p>
            @endif
        </div>


        <!-- Password -->
        <div class="mt-5">
            <label
                for="password"
                class="block text-sm font-semibold text-slate-800 mb-2"
            >
                Password
            </label>

            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"

                class="w-full px-4 py-3
                       rounded-xl
                       border border-white/70
                       bg-white/70
                       backdrop-blur-sm
                       text-slate-800
                       shadow-sm
                       focus:outline-none
                       focus:ring-2
                       focus:ring-teal-500
                       focus:border-transparent"
            >

            @if($errors->get('password'))
                <p class="mt-2 text-sm text-red-700">
                    {{ $errors->first('password') }}
                </p>
            @endif
        </div>


        <!-- Confirm Password -->
        <div class="mt-5">
            <label
                for="password_confirmation"
                class="block text-sm font-semibold text-slate-800 mb-2"
            >
                Confirm Password
            </label>

            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"

                class="w-full px-4 py-3
                       rounded-xl
                       border border-white/70
                       bg-white/70
                       backdrop-blur-sm
                       text-slate-800
                       shadow-sm
                       focus:outline-none
                       focus:ring-2
                       focus:ring-teal-500
                       focus:border-transparent"
            >
        </div>


        <!-- Buttons -->
        <div class="flex items-center justify-between mt-7">

            <!-- Already Registered -->
            <a
                href="{{ route('login', ['role' => request('role', 'student')]) }}"
                class="text-sm font-medium
                       text-slate-700
                       hover:text-slate-900
                       underline
                       transition"
            >
                Already registered?
            </a>


            <!-- Register -->
            <button
                type="submit"
                class="px-6 py-3
                       bg-teal-600
                       hover:bg-teal-700
                       text-white
                       font-semibold
                       rounded-xl
                       shadow-lg
                       hover:shadow-xl
                       transition-all
                       duration-200"
            >
                Register
            </button>

        </div>

    </form>

</x-guest-layout>