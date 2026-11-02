<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-blue-700">
                Gradely Teacher Portal
            </p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                Register Student
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-4xl px-6 sm:px-8">

            <a href="{{ route('teacher.classes.students.index', $class) }}"
               class="text-sm font-semibold text-blue-900 hover:underline">
                ← Back to Student List
            </a>

            <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">

                <h3 class="text-2xl font-bold text-slate-900">
                    Student Information
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Register a student under {{ $class->class_name }}.
                </p>

                @if ($errors->any())
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <p class="font-bold">Please correct the following:</p>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('teacher.classes.students.store', $class) }}"
                      class="mt-8 space-y-6">

                    @csrf

                    <div>
                        <label for="lrn" class="block text-sm font-semibold text-slate-700">
                            Learner Reference Number (LRN) *
                        </label>
                        <input id="lrn" name="lrn" type="text"
                               value="{{ old('lrn') }}"
                               maxlength="20" required
                               class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900">
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-slate-700">
                                First Name *
                            </label>
                            <input id="first_name" name="first_name" type="text"
                                   value="{{ old('first_name') }}" required
                                   class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900">
                        </div>

                        <div>
                            <label for="middle_name" class="block text-sm font-semibold text-slate-700">
                                Middle Name
                            </label>
                            <input id="middle_name" name="middle_name" type="text"
                                   value="{{ old('middle_name') }}"
                                   class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900">
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-slate-700">
                                Last Name *
                            </label>
                            <input id="last_name" name="last_name" type="text"
                                   value="{{ old('last_name') }}" required
                                   class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900">
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-sm font-semibold text-slate-700">
                                Date of Birth *
                            </label>
                            <input id="date_of_birth" name="date_of_birth" type="date"
                                   value="{{ old('date_of_birth') }}"
                                   max="{{ date('Y-m-d') }}" required
                                   class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900">
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-semibold text-slate-700">
                                Gender *
                            </label>
                            <select id="gender" name="gender" required
                                    class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900">
                                <option value="">Select Gender</option>
                                <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                                <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-semibold text-slate-700">
                            Address
                        </label>
                        <textarea id="address" name="address" rows="3"
                                  class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900">{{ old('address') }}</textarea>
                    </div>

                    <div class="rounded-xl bg-blue-50 p-4">
                        <p class="text-sm font-semibold text-blue-950">
                            Assigned Classroom
                        </p>
                        <p class="mt-1 text-sm text-blue-800">
                            {{ $class->class_name }} — {{ $class->grade_level }},
                            Section {{ $class->section }}
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                        <a href="{{ route('teacher.classes.students.index', $class) }}"
                           class="rounded-xl border border-slate-300 px-6 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Cancel
                        </a>

                        <button type="submit"
                                style="background-color: #172554; color: white;"
                                class="rounded-xl px-6 py-3 text-sm font-semibold hover:opacity-90">
                            Register Student
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>