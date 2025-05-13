<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Szczegóły oceny
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-3xl mx-auto">
        <a href="{{ route('teacher.grades.index') }}" class="mb-4 inline-block text-sm text-blue-600 hover:underline">← Powrót do listy ocen</a>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Uczeń:</span>
                <span class="text-gray-900 dark:text-white">{{ $grade->student->name }}</span>
            </div>

            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Przedmiot:</span>
                <span class="text-gray-900 dark:text-white">{{ $grade->subject }}</span>
            </div>

            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Ocena:</span>
                <span class="text-gray-900 dark:text-white font-semibold">{{ $grade->grade }}</span>
            </div>

            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Komentarz:</span>
                <span class="text-gray-900 dark:text-white">{{ $grade->comment ?: 'Brak' }}</span>
            </div>

            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Data dodania:</span>
                <span class="text-gray-900 dark:text-white">{{ $grade->created_at->format('d-m-y H:i') }}</span>
            </div>
        </div>
    </div>
</x-app-layout>
