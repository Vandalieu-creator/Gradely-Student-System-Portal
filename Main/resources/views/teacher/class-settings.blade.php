
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Settings - Gradely</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body
    class="min-h-screen bg-slate-100"
    x-data="{
        sidebarCollapsed: localStorage.getItem('gradely_teacher_sidebar_collapsed') === 'true',
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('gradely_teacher_sidebar_collapsed', this.sidebarCollapsed);
        }
    }">

<div class="min-h-screen flex">

    <!-- Teacher Sidebar -->
    <div class="hidden md:block shrink-0 sticky top-0 h-screen">
        <x-teacher-sidebar active="class-settings" />
    </div>

    <!-- Main Content -->
    <div class="flex-1 min-w-0 p-4 md:p-6">

        <main class="max-w-[1600px] mx-auto bg-[#f8fafc] min-h-screen rounded-xl p-4 md:p-7">

            <!-- Header -->
            <header class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">

                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-800">
                        Class Settings
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Ginatilan Elementary School
                        <span class="mx-1">•</span>
                        School Year 2026-2027
                    </p>
                </div>

                <!-- Teacher Profile -->
                <div class="flex items-center gap-3">

                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-800">
                            Teacher {{ auth('teacher')->user()->first_name }}
                            {{ auth('teacher')->user()->last_name }}
                        </p>

                        <p class="text-xs text-slate-500">
                            Teacher Account
                        </p>
                    </div>

                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center">
                        <i class="fas fa-user text-slate-500"></i>
                    </div>

                </div>

            </header>

            <!-- Class Settings Content -->
            <section class="bg-white border border-slate-200 rounded-xl p-6 md:p-8">

                <div class="flex items-center gap-3 mb-5">

                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-gear text-blue-600 text-xl"></i>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-slate-800">
                            Class Configuration
                        </h2>

                        <p class="text-sm text-slate-500">
                            Classroom preferences and configuration workspace
                        </p>
                    </div>

                </div>

                <div class="border-t border-slate-100 pt-5">

                    <p class="text-sm text-slate-500">
                        The Class Settings page is ready for future development.
                    </p>

                </div>

            </section>

        </main>

    </div>

</div>

</body>
</html>
