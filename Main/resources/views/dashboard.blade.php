<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gradely - Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dashboardBg: '#E9E2E8',
                        cardBg: '#F7F2F6',
                        sidebarBg: '#EFE7EE',
                        accentPurp: '#785A74',
                        mutedText: '#9A8696',
                        darkText: '#4A3B48',
                        activeTab: '#E2D5E0',
                        ringPink: '#E87A90',
                        ringTeal: '#63B3A6',
                        ringYellow: '#ECC94B'
                    },
                    fontFamily: {
                        sans: ['Quicksand', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-dashboardBg min-h-screen text-darkText font-sans antialiased flex items-center justify-center p-2 sm:p-6 lg:p-8">

    <div class="w-full max-w-7xl bg-cardBg rounded-[3rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-white/50">

        <!-- Sidebar Navigation -->
        <aside class="w-full lg:w-72 bg-sidebarBg p-8 flex flex-col justify-between shrink-0 border-b lg:border-b-0 lg:border-r border-accentPurp/10">
            <div>
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-2 mb-8">
                    <h1 class="text-2xl font-bold tracking-wide text-darkText">Smartech</h1>
                    <span class="w-2 h-2 bg-accentPurp rounded-full"></span>
                </div>

                <!-- User Profile Badge -->
                <div class="flex items-center space-x-3 mb-10 bg-white/40 p-3 rounded-2xl shadow-sm">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Profile" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h2 class="font-bold text-sm text-darkText">{{ Auth::user()->name ?? 'Student' }}</h2>
                        <p class="text-xs text-mutedText font-medium">Student</p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="space-y-2">
                    <a href="#" class="flex items-center space-x-4 py-3 px-4 rounded-2xl bg-activeTab text-darkText font-bold shadow-sm transition">
                        <i class="fa-solid fa-table-cells-large w-5 text-accentPurp"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-4 py-3 px-4 rounded-2xl text-mutedText hover:bg-white/30 hover:text-darkText font-medium transition">
                        <i class="fa-solid fa-graduation-cap w-5"></i>
                        <span>My classes</span>
                    </a>
                    <a href="#" class="flex items-center space-x-4 py-3 px-4 rounded-2xl text-mutedText hover:bg-white/30 hover:text-darkText font-medium transition">
                        <i class="fa-solid fa-file-lines w-5"></i>
                        <span>My grades</span>
                    </a>
                    <a href="#" class="flex items-center space-x-4 py-3 px-4 rounded-2xl text-mutedText hover:bg-white/30 hover:text-darkText font-medium transition">
                        <i class="fa-solid fa-calendar-days w-5"></i>
                        <span>Schedule</span>
                    </a>
                    <a href="#" class="flex items-center space-x-4 py-3 px-4 rounded-2xl text-mutedText hover:bg-white/30 hover:text-darkText font-medium transition">
                        <i class="fa-solid fa-envelope w-5"></i>
                        <span>Messages</span>
                    </a>
                    <a href="#" class="flex items-center space-x-4 py-3 px-4 rounded-2xl text-mutedText hover:bg-white/30 hover:text-darkText font-medium transition">
                        <i class="fa-solid fa-gear w-5"></i>
                        <span>Setting</span>
                    </a>
                </nav>
            </div>

            <!-- Logout Button -->
            <div class="mt-8 pt-4 border-t border-accentPurp/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-4 py-3 px-4 w-full rounded-2xl text-mutedText hover:bg-red-500/10 hover:text-red-600 font-medium transition text-left">
                        <i class="fa-solid fa-right-from-bracket w-5"></i>
                        <span>Log out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Section -->
        <main class="flex-1 p-6 lg:p-10 flex flex-col justify-between overflow-y-auto">
            <div>
                <!-- Top Header Bar -->
                <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <h2 class="text-2xl lg:text-3xl font-extrabold tracking-tight text-darkText">
                        HELLO, {{ strtoupper(Auth::user()->name ?? 'STUDENT') }}!
                    </h2>
                    
                    <div class="flex items-center space-x-4 w-full sm:w-auto justify-end">
                        <!-- Search Bar -->
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-mutedText">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input type="text" placeholder="search" class="w-full bg-white/70 border border-white text-sm rounded-full pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-accentPurp/30 placeholder-mutedText shadow-inner">
                        </div>
                        <!-- Notification & Menu Icons -->
                        <button class="w-10 h-10 rounded-full bg-white/70 flex items-center justify-center text-accentPurp shadow-sm hover:bg-white transition relative">
                            <i class="fa-regular fa-bell text-sm"></i>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-ringPink rounded-full"></span>
                        </button>
                        <button class="w-10 h-10 rounded-full bg-white/70 flex items-center justify-center text-accentPurp shadow-sm hover:bg-white transition">
                            <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                        </button>
                    </div>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Linked Teachers Widget -->
                    <div class="bg-white/60 backdrop-blur-sm p-6 rounded-[2rem] shadow-sm border border-white">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-darkText text-base">Linked Teachers</h3>
                            <a href="#" class="text-xs text-mutedText hover:text-darkText font-semibold transition">See more <i class="fa-solid fa-chevron-right text-[10px]"></i></a>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-2 bg-white/40 rounded-2xl">
                                <div class="flex items-center space-x-3">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <h4 class="font-bold text-xs text-darkText">Olivia Miller</h4>
                                        <p class="text-[11px] text-mutedText">mentor</p>
                                    </div>
                                </div>
                                <button class="w-8 h-8 rounded-full bg-accentPurp/10 text-accentPurp flex items-center justify-center hover:bg-accentPurp hover:text-white transition"><i class="fa-regular fa-comment text-xs"></i></button>
                            </div>

                            <div class="flex items-center justify-between p-2 bg-white/40 rounded-2xl">
                                <div class="flex items-center space-x-3">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <h4 class="font-bold text-xs text-darkText">Liam Garcia</h4>
                                        <p class="text-[11px] text-mutedText">teacher</p>
                                    </div>
                                </div>
                                <button class="w-8 h-8 rounded-full bg-accentPurp/10 text-accentPurp flex items-center justify-center hover:bg-accentPurp hover:text-white transition"><i class="fa-regular fa-comment text-xs"></i></button>
                            </div>

                            <div class="flex items-center justify-between p-2 bg-white/40 rounded-2xl">
                                <div class="flex items-center space-x-3">
                                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=100&q=80" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <h4 class="font-bold text-xs text-darkText">Jackson Lopez</h4>
                                        <p class="text-[11px] text-mutedText">lecturer</p>
                                    </div>
                                </div>
                                <button class="w-8 h-8 rounded-full bg-accentPurp/10 text-accentPurp flex items-center justify-center hover:bg-accentPurp hover:text-white transition"><i class="fa-regular fa-comment text-xs"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Events Widget -->
                    <div class="bg-white/60 backdrop-blur-sm p-6 rounded-[2rem] shadow-sm border border-white">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-darkText text-base">Upcoming events</h3>
                            <a href="#" class="text-xs text-mutedText hover:text-darkText font-semibold transition">See more <i class="fa-solid fa-chevron-right text-[10px]"></i></a>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-white/40 rounded-2xl">
                                <div class="flex items-center space-x-3">
                                    <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=100&q=80" class="w-10 h-10 rounded-xl object-cover">
                                    <div>
                                        <h4 class="font-bold text-xs text-darkText">The main event in your life</h4>
                                        <p class="text-[10px] text-mutedText">22 May 2023</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-darkText bg-white/80 px-3 py-1.5 rounded-xl shadow-xs">13:00</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-white/40 rounded-2xl">
                                <div class="flex items-center space-x-3">
                                    <img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=100&q=80" class="w-10 h-10 rounded-xl object-cover">
                                    <div>
                                        <h4 class="font-bold text-xs text-darkText">Webinar of new tools in</h4>
                                        <p class="text-[10px] text-mutedText">31 May 2023</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-darkText bg-white/80 px-3 py-1.5 rounded-xl shadow-xs">11:00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- My Schedule Widget -->
                    <div class="lg:col-span-2 bg-white/60 backdrop-blur-sm p-6 rounded-[2rem] shadow-sm border border-white flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-darkText text-base mb-4">My schedule</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Calendar Card -->
                                <div class="bg-white/50 p-4 rounded-2xl shadow-xs">
                                    <div class="flex justify-between items-center mb-3">
                                        <button class="text-mutedText hover:text-darkText"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                                        <span class="font-bold text-xs text-darkText">May 2023</span>
                                        <button class="text-mutedText hover:text-darkText"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                                    </div>
                                    <div class="grid grid-cols-7 gap-1 text-center text-[10px] text-mutedText font-semibold mb-2">
                                        <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                                    </div>
                                    <div class="grid grid-cols-7 gap-1 text-center text-xs text-darkText font-medium">
                                        <span class="py-1 text-mutedText">29</span><span class="py-1 text-mutedText">30</span><span class="py-1">1</span><span class="py-1">2</span><span class="py-1">3</span><span class="py-1">4</span><span class="py-1">5</span>
                                        <span class="py-1">6</span><span class="py-1">7</span><span class="py-1">8</span><span class="py-1">9</span><span class="py-1">10</span><span class="py-1">11</span><span class="py-1">12</span>
                                        <span class="py-1">13</span><span class="py-1">14</span><span class="py-1">15</span><span class="py-1 bg-accentPurp text-white rounded-full font-bold shadow-sm">16</span><span class="py-1">17</span><span class="py-1">18</span><span class="py-1">19</span>
                                        <span class="py-1">20