<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Szczegóły oceny
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 space-y-6">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Ocena z przedmiotu {{ $grade->subject }}</h3>
                <a href="{{ route('student.grades.index') }}"
                   class="text-sm text-indigo-600 hover:underline">← Powrót do listy ocen</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Ocena</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $grade->grade }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Data wystawienia</p>
                    <p class="text-lg text-gray-800 dark:text-white">{{ $grade->created_at->format('d/m/y') }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nauczyciel</p>
                    <p class="text-lg text-gray-800 dark:text-white">{{ $grade->teacher->name ?? 'Nieznany' }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Komentarz</p>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $grade->comment ?? 'Brak komentarza.' }}
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('student.grades.statistics') }}"
                   class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-md hover:bg-emerald-700 transition">
                    Zobacz statystyki
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
