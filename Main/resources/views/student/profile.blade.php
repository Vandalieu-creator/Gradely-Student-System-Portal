
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Ginatilan Elementary School</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        skyBg: '#E0F2FE',
                        cardBg: '#FFFFFF',
                        kidPurple: '#C084FC',
                        kidPink: '#F472B6',
                        kidYellow: '#FDE047',
                        kidGreen: '#4ADE80',
                        kidOrange: '#FB923C',
                        kidBlue: '#38BDF8',
                        darkText: '#1E293B'
                    },
                    fontFamily: {
                        sans: ['Fredoka', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-skyBg min-h-screen text-darkText font-sans antialiased overflow-x-hidden"
      x-data="{
          showModal: false,
          showTeacherModal: false,
          showScheduleModal: false,
          showHelpModal: false,
          showToast: false,
          teacherMessage: '',
          taskDone: false,
          stars: 125,
          sidebarCollapsed: localStorage.getItem('gradely_student_sidebar_collapsed') === 'true',
          mobileSidebarOpen: false,
          showQuickFind: false,
          quickSearchQuery: '',
          toggleSidebar() {
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('gradely_student_sidebar_collapsed', this.sidebarCollapsed);
          },
          sendTeacherMessage() {
              if (this.teacherMessage.trim() === '') return;
              this.showTeacherModal = false;
              this.teacherMessage = '';
              this.showToast = true;
              setTimeout(() => { this.showToast = false; }, 3500);
          }
      }">

    @include('student.partials.student-modals')
    @include('student.partials.quick-find')

    <div class="min-h-screen flex flex-row relative">

        <!-- Desktop Sidebar -->
        <div class="hidden md:block shrink-0 sticky top-0 h-screen">
            @include('student.partials.sidebar', ['active' => 'profile'])
        </div>

        <!-- Mobile Sidebar Drawer -->
        <div x-show="mobileSidebarOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="md:hidden fixed inset-0 z-50 flex"
             style="display: none;">

            <div @click="mobileSidebarOpen = false"
                 class="fixed inset-0 bg-black/60 backdrop-blur-xs"></div>

            <div class="relative flex-1 flex flex-col max-w-[270px] w-full h-full z-10 shadow-2xl">
                <button @click="mobileSidebarOpen = false"
                        class="absolute top-4 -right-11 bg-white text-slate-800 w-9 h-9 rounded-full shadow-lg flex items-center justify-center z-50">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                @include('student.partials.sidebar', ['active' => 'profile'])
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen">

            <!-- Mobile Header -->
            <div class="md:hidden flex items-center justify-between bg-[#142236] px-4 py-3 shadow-md">
                <button @click="mobileSidebarOpen = true"
                        class="text-white text-xl p-2">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <span class="text-white font-bold">My Profile</span>

                <div class="w-8"></div>
            </div>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">

                <!-- Page Heading -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">
                        <a href="{{ route('student.dashboard') }}"
                           class="hover:text-sky-600 transition">
                            Dashboard
                        </a>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        <span class="text-sky-600 font-semibold">My Profile</span>
                    </div>

                    <h1 class="text-3xl font-bold text-darkText flex items-center gap-3">
                        <span class="w-11 h-11 rounded-2xl bg-kidBlue/20 text-sky-600 flex items-center justify-center">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        My Profile
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Manage your personal information and account security.
                    </p>
                </div>

                <!-- Success Messages -->
                @if(session('success'))
                    <div class="mb-5 p-4 rounded-2xl bg-green-100 border border-green-200 text-green-700 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('password_success'))
                    <div class="mb-5 p-4 rounded-2xl bg-green-100 border border-green-200 text-green-700 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('password_success') }}
                    </div>
                @endif

                <!-- Profile Information Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-sky-100 overflow-hidden mb-6">

                    <div class="bg-gradient-to-r from-sky-500 to-cyan-400 p-6 text-white">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>

                            <div>
                                <h2 class="text-xl font-bold">
                                    {{ $user->name }}
                                </h2>
                                <p class="text-sm text-sky-50">
                                    Student Account
                                </p>
                                <p class="text-xs text-white/80 mt-1">
                                    LRN: {{ $user->lrn }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 sm:p-7">

                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-darkText">
                                Personal Information
                            </h3>
                            <p class="text-sm text-slate-400">
                                Update your personal details below.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('student.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <!-- First Name -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        First Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="first_name"
                                           value="{{ old('first_name', $student->first_name) }}"
                                           required
                                           maxlength="255"
                                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500">
                                    @error('first_name')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Middle Name -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Middle Name
                                    </label>
                                    <input type="text"
                                           name="middle_name"
                                           value="{{ old('middle_name', $student->middle_name) }}"
                                           maxlength="255"
                                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500">
                                    @error('middle_name')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Last Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="last_name"
                                           value="{{ old('last_name', $student->last_name) }}"
                                           required
                                           maxlength="255"
                                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500">
                                    @error('last_name')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Date of Birth
                                    </label>
                                    <input type="date"
                                           name="date_of_birth"
                                           value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}"
                                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500">
                                    @error('date_of_birth')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Gender
                                    </label>
                                    <select name="gender"
                                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500">
                                        <option value="">Select gender</option>
                                        <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- LRN -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Learner Reference Number (LRN)
                                    </label>
                                    <input type="text"
                                           value="{{ $user->lrn }}"
                                           readonly
                                           class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500 cursor-not-allowed">
                                    <p class="text-xs text-slate-400 mt-1">
                                        Your LRN cannot be changed here.
                                    </p>
                                </div>

                                <!-- Class Assignment -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Class Assignment
                                    </label>
                                    <input type="text"
                                           value="{{ $student->class_id ? 'Class ID: ' . $student->class_id : 'Not assigned' }}"
                                           readonly
                                           class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500 cursor-not-allowed">
                                    <p class="text-xs text-slate-400 mt-1">
                                        Contact your teacher if your class assignment needs correction.
                                    </p>
                                </div>

                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Address
                                    </label>
                                    <textarea name="address"
                                              rows="3"
                                              maxlength="255"
                                              class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500"
                                              placeholder="Enter your home address">{{ old('address', $student->address) }}</textarea>
                                    @error('address')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                        class="px-6 py-3 rounded-xl bg-sky-500 hover:bg-sky-600 text-white font-bold text-sm shadow-md transition">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Security Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-purple-100 overflow-hidden">

                    <div class="p-5 sm:p-7">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-11 h-11 rounded-xl bg-kidPurple/20 text-purple-600 flex items-center justify-center">
                                <i class="fa-solid fa-shield-halved text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-darkText">
                                    Account Security
                                </h3>
                                <p class="text-sm text-slate-400">
                                    Change your password whenever you need to.
                                </p>
                            </div>
                        </div>

                        <div class="bg-purple-50 border border-purple-100 rounded-xl p-3 text-sm text-purple-700 my-5">
                            <i class="fa-solid fa-lightbulb mr-1"></i>
                            For your security, we recommend using a password known only to you.
                        </div>

                        <form method="POST" action="{{ route('student.profile.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <!-- Current Password -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Current Password
                                    </label>
                                    <input type="password"
                                           name="current_password"
                                           required
                                           autocomplete="current-password"
                                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-purple-500 focus:ring-purple-500">
                                    @error('current_password')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        New Password
                                    </label>
                                    <input type="password"
                                           name="password"
                                           required
                                           minlength="8"
                                           autocomplete="new-password"
                                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-purple-500 focus:ring-purple-500">
                                    @error('password')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Confirm New Password
                                    </label>
                                    <input type="password"
                                           name="password_confirmation"
                                           required
                                           minlength="8"
                                           autocomplete="new-password"
                                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-purple-500 focus:ring-purple-500">
                                </div>

                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                        class="px-6 py-3 rounded-xl bg-purple-500 hover:bg-purple-600 text-white font-bold text-sm shadow-md transition">
                                    <i class="fa-solid fa-lock mr-2"></i>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-center text-xs text-slate-400 mt-8">
                    Ginatilan Elementary School · Gradely Student Portal
                </p>

            </main>
        </div>
    </div>
</body>
</html>
