<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Statystyki ocen') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <a href="{{ route('student.grades.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-semibold uppercase rounded-md hover:bg-indigo-700 transition duration-150 ease-in-out">
                            ← Powrót do listy ocen
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-indigo-50 dark:bg-indigo-900 p-6 rounded-lg shadow">
                            <h3 class="text-md font-medium text-gray-800 dark:text-white mb-2">Średnia ocen</h3>
                            <p class="text-3xl font-bold text-indigo-700 dark:text-indigo-300">
                                {{ number_format($average, 2) }}
                            </p>
                        </div>

                        <div class="bg-green-50 dark:bg-green-900 p-6 rounded-lg shadow">
                            <h3 class="text-md font-medium text-gray-800 dark:text-white mb-2">Liczba ocen</h3>
                            <p class="text-3xl font-bold text-green-700 dark:text-green-300">
                                {{ $count }}
                            </p>
                        </div>

                        <div class="bg-yellow-50 dark:bg-yellow-900 p-6 rounded-lg shadow">
                            <h3 class="text-md font-medium text-gray-800 dark:text-white mb-2">Najwyższa ocena</h3>
                            <p class="text-3xl font-bold text-yellow-700 dark:text-yellow-300">
                                {{ $max }}
                            </p>
                        </div>

                        <div class="bg-red-50 dark:bg-red-900 p-6 rounded-lg shadow">
                            <h3 class="text-md font-medium text-gray-800 dark:text-white mb-2">Najniższa ocena</h3>
                            <p class="text-3xl font-bold text-red-700 dark:text-red-300">
                                {{ $min }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Oceny według przedmiotów</h4>
                        <ul class="space-y-2">
                            @forelse ($gradesBySubject as $subject => $grades)
                                <li class="flex justify-between bg-gray-100 dark:bg-gray-700 p-3 rounded-md">
                                    <span class="font-medium">{{ $subject }}</span>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">
                                        Śr: {{ number_format($grades->avg('grade'), 2) }} | Ilość: {{ $grades->count() }}
                                    </span>
                                </li>
                            @empty
                                <li class="text-gray-600 dark:text-gray-400">Brak danych do wyświetlenia.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
