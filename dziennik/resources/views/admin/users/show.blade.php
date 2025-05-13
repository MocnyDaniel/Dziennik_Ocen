<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Szczegóły użytkownika
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">
                Informacje o użytkowniku
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-200">
                <div>
                    <span class="font-semibold">Imię i nazwisko:</span><br>
                    {{ $user->name }}
                </div>
                <div>
                    <span class="font-semibold">Email:</span><br>
                    {{ $user->email }}
                </div>
                <div>
                    <span class="font-semibold">Rola:</span><br>
                    {{ ucfirst($user->role) }}
                </div>
                <div>
                    <span class="font-semibold">Utworzony:</span><br>
                    {{ $user->created_at->format('Y-m-d H:i') }}
                </div>
                <div>
                    <span class="font-semibold">Ostatnia aktualizacja:</span><br>
                    {{ $user->updated_at->format('Y-m-d H:i') }}
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 transition">
                    Edytuj
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white hover:bg-gray-600 transition">
                    Wróć
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
