<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Moje oceny
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <!-- Komunikat sesji -->
        @if (session('status'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Filtry -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Przedmiot</label>
                    <input type="text" name="subject" id="subject" value="{{ request('subject') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:text-white sm:text-sm" />
                </div>
                <div>
                    <label for="from" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Od</label>
                    <input type="date" name="from" id="from" value="{{ request('from') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:text-white sm:text-sm" />
                </div>
                <div>
                    <label for="to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Do</label>
                    <input type="date" name="to" id="to" value="{{ request('to') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:text-white sm:text-sm" />
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">Filtruj</button>
                </div>
            </form>
            <div class="mt-4 text-right">
                <a href="{{ route('student.grades.index', array_merge(request()->all(), ['export' => 'csv'])) }}"
                    class="text-sm text-indigo-600 hover:underline">Eksportuj do CSV</a>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">Lista ocen</h3>
            <a href="{{ route('student.grades.statistics') }}"
               class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:outline-none transition ease-in-out duration-150">
                Zobacz statystyki
            </a>
        </div>

        <!-- Tabela ocen -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Przedmiot</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ocena</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nauczyciel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($grades as $grade)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $grade->subject }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $grade->grade }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $grade->teacher->name ?? 'Nieznany' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $grade->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('student.grades.show', $grade) }}" class="text-indigo-600 hover:text-indigo-900">Szczegóły</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Brak ocen do wyświetlenia. Spróbuj zmienić filtry lub poczekaj na nowe oceny.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginacja -->
            <div class="p-4">
                {{ $grades->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
