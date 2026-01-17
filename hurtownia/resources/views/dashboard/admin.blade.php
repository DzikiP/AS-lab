<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel administratora
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h2 class="text-xl font-bold">Witaj, {{ auth()->user()->username }}</h2>
                <p class="mt-2 text-gray-700">Masz dostęp do zarządzania użytkownikami systemu</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold">Użytkownicy</h3>
                    <p class="mt-2 text-2xl font-bold text-blue-600">{{ $usersCount ?? 0 }}</p>
                    <a href="{{ route('users.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Zarządzaj użytkownikami
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
