<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">
                        Welcome, {{ auth()->user()->name }}!
                    </h3>

                    <p class="text-gray-600">
                        This is the Gradely Administrator Dashboard.
                    </p>
                </div>
            </div>

            <!-- Management Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Teachers -->
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Teachers
                    </h3>

                    <p class="mt-2 text-gray-600">
                        Manage teachers and their accounts.
                    </p>

                    <button
                        class="mt-4 px-4 py-2 bg-gray-800 text-white rounded">
                        Manage Teachers
                    </button>
                </div>

                <!-- Parents -->
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Parents
                    </h3>

                    <p class="mt-2 text-gray-600">
                        Manage parent accounts.
                    </p>

                    <button
                        class="mt-4 px-4 py-2 bg-gray-800 text-white rounded">
                        Manage Parents
                    </button>
                </div>

                <!-- Students -->
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Students
                    </h3>

                    <p class="mt-2 text-gray-600">
                        Manage student records.
                    </p>

                    <button
                        class="mt-4 px-4 py-2 bg-gray-800 text-white rounded">
                        Manage Students
                    </button>
                </div>

                <!-- Subjects -->
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Subjects
                    </h3>

                    <p class="mt-2 text-gray-600">
                        Manage school subjects.
                    </p>

                    <button
                        class="mt-4 px-4 py-2 bg-gray-800 text-white rounded">
                        Manage Subjects
                    </button>
                </div>

                <!-- Sections -->
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Sections
                    </h3>

                    <p class="mt-2 text-gray-600">
                        Manage sections and class assignments.
                    </p>

                    <button
                        class="mt-4 px-4 py-2 bg-gray-800 text-white rounded">
                        Manage Sections
                    </button>
                </div>

                <!-- Reports -->
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Reports
                    </h3>

                    <p class="mt-2 text-gray-600">
                        View school reports and records.
                    </p>

                    <button
                        class="mt-4 px-4 py-2 bg-gray-800 text-white rounded">
                        View Reports
                    </button>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>