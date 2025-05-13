<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edytuj ocenę
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-3xl mx-auto">
        <a href="{{ route('teacher.grades.index') }}"
           class="mb-4 inline-block text-sm text-blue-600 hover:underline">← Powrót do listy ocen</a>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('teacher.grades.update', $grade) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uczeń</label>
                    <select name="student_id" id="student_id"
                        class="mt-1 block w-full rounded-md dark:bg-gray-900 dark:text-white border-gray-300 dark:border-gray-700 shadow-sm">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $student->id == $grade->student_id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Przedmiot</label>
                    <input type="text" name="subject" id="subject" value="{{ $grade->subject }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm" />
                </div>

                <div class="mb-4">
                    <label for="grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ocena</label>
                    <input type="number" name="grade" step="0.1" min="1" max="6" value="{{ $grade->grade }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm" />
                </div>

                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Komentarz</label>
                    <textarea name="comment" id="comment" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">{{ $grade->comment }}</textarea>
                </div>

                <div class="text-right">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                        Zaktualizuj ocenę
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
