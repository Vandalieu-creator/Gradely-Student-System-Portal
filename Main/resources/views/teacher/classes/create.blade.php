<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Class
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-2xl font-bold mb-2">
                    Create a New Class
                </h3>

                <p class="text-gray-600 mb-6">
                    Enter the details of the class you will manage.
                </p>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('teacher.classes.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="class_name" class="block font-medium text-gray-700">
                            Class Name
                        </label>
                        <input
                            type="text"
                            id="class_name"
                            name="class_name"
                            value="{{ old('class_name') }}"
                            placeholder="Example: Grade 1 - Section A"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="grade_level" class="block font-medium text-gray-700">
                            Grade Level
                        </label>
                        <select
                            id="grade_level"
                            name="grade_level"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                            <option value="">Select Grade Level</option>
                            @foreach (range(1, 6) as $grade)
                                <option value="Grade {{ $grade }}"
                                    {{ old('grade_level') == "Grade $grade" ? 'selected' : '' }}>
                                    Grade {{ $grade }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="section" class="block font-medium text-gray-700">
                            Section
                        </label>
                        <input
                            type="text"
                            id="section"
                            name="section"
                            value="{{ old('section') }}"
                            placeholder="Example: Section A"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="school_year" class="block font-medium text-gray-700">
                            School Year
                        </label>
                        <input
                            type="text"
                            id="school_year"
                            name="school_year"
                            value="{{ old('school_year') }}"
                            placeholder="Example: 2026-2027"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div class="mb-6">
                        <label for="room" class="block font-medium text-gray-700">
                            Room (Optional)
                        </label>
                        <input
                            type="text"
                            id="room"
                            name="room"
                            value="{{ old('room') }}"
                            placeholder="Example: Room 1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="submit"
                            class="rounded-md bg-blue-600 px-5 py-2 text-white hover:bg-blue-700"
                        >
                            Create Class
                        </button>

                        <a
                            href="{{ route('teacher.classes.index') }}"
                            class="rounded-md bg-gray-200 px-5 py-2 text-gray-700 hover:bg-gray-300"
                        >
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>