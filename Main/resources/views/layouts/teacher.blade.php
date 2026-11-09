@props(['active' => 'dashboard', 'title' => 'Teacher Portal'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} — Ginatilan Elementary School Teacher Portal</title>

    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fredoka:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['Fredoka', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            400: '#38bdf8',
                            500: '#00adef',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            navy: '#101a2a',
                        }
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
<body class="h-full bg-slate-50 text-slate-800 font-sans antialiased overflow-x-hidden"
      x-data="{
          sidebarCollapsed: localStorage.getItem('gradely_teacher_sidebar_collapsed') === 'true',
          mobileSidebarOpen: false,
          showQuickFind: false,
          showAnnouncementModal: false,
          showAssignmentModal: false,
          showUploadModal: false,
          showMessageModal: false,
          showToast: false,
          toastMessage: '',
          toastTitle: 'Success!',
          toggleSidebar() {
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('gradely_teacher_sidebar_collapsed', this.sidebarCollapsed);
          },
          notify(msg, title = 'Success!') {
              this.toastMessage = msg;
              this.toastTitle = title;
              this.showToast = true;
              setTimeout(() => { this.showToast = false; }, 4000);
          }
      }">

    <!-- Quick Find Global Command Palette (Ctrl+K / Cmd+K) -->
    @include('teacher.partials.quick-find')

    <!-- Teacher Global Action Modals & Toast -->
    @include('teacher.partials.modals')

    <!-- Layout Wrapper with Teacher Sidebar -->
    <div class="min-h-screen flex flex-row relative">

        <!-- ============================================================== -->
        <!-- DESKTOP TEACHER SIDEBAR (Sticky Left, ≥ md)                     -->
        <!-- ============================================================== -->
        <div class="hidden md:block shrink-0 sticky top-0 h-screen">
            @include('teacher.partials.sidebar', ['active' => $active])
        </div>

        <!-- ============================================================== -->
        <!-- MOBILE DRAWER SIDEBAR (< md)                                   -->
        <!-- ============================================================== -->
        <div x-show="mobileSidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="md:hidden fixed inset-0 z-50 flex"
             style="display: none;">
            
            <!-- Backdrop -->
            <div @click="mobileSidebarOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-xs"></div>

            <!-- Drawer Container -->
            <div class="relative flex-1 flex flex-col max-w-[270px] w-full h-full z-10 shadow-2xl">
                <!-- Mobile Close Button -->
                <button @click="mobileSidebarOpen = false" 
                        title="Close Menu"
                        class="absolute top-3 right-3 z-50 h-8 w-8 rounded-full bg-slate-800/80 text-white flex items-center justify-center border border-white/20 cursor-pointer shadow-md hover:bg-slate-700">
                    ✕
                </button>
                @include('teacher.partials.sidebar', ['active' => $active])
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- MAIN CONTENT COLUMN                                            -->
        <!-- ============================================================== -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen">
            
            <!-- Mobile Sticky Header Bar (< md) -->
            <div class="md:hidden flex items-center justify-between px-4 py-3 bg-[#101a2a] text-white shadow-md sticky top-0 z-30 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <!-- Mobile Hamburger Button -->
                    <button @click="mobileSidebarOpen = true" 
                            title="Open Teacher Menu"
                            class="p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white cursor-pointer focus:outline-none transition">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    
                    <!-- Cyan Teacher Badge -->
                    <div class="flex items-center space-x-2 bg-[#00adef] px-3 py-1.5 rounded-xl text-white shadow-xs">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 4.5c1.2-1.5 2.8-2.5 4.5-2.5 0 2-1 3.5-2.5 4.5"/>
                            <path d="M8.5 7.5C5.5 7.5 3 9.8 3 13.5c0 4.5 3.2 8.5 6 8.5 1.4 0 2.2-.8 3-0.8s1.6.8 3 .8c2.8 0 6-4 6-8.5 0-3.7-2.5-6-5.5-6-1.5 0-2.8.8-3.5 1.5-.7-.7-2-1.5-3.5-1.5z"/>
                        </svg>
                        <span class="text-xs font-bold">Teacher</span>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <button @click="showQuickFind = true" 
                            title="Quick Find (⌘K)"
                            class="p-2 rounded-xl bg-white/10 text-slate-300 hover:text-white cursor-pointer transition">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                    
                    <a href="{{ route('teacher.messages.index') }}" 
                       class="relative p-2 rounded-xl bg-white/10 text-slate-300 hover:text-white transition">
                        <i class="fa-solid fa-bell text-sm"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-red-500"></span>
                    </a>
                </div>
            </div>

            <!-- Page Slot Content -->
            <main class="flex-1 min-w-0">
                {{ $slot }}
            </main>
        </div>

    </div>

</body>
</html>
