<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Użytkownicy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Wyszukiwanie --}}
            <div class="mb-4 flex justify-between">
                <form method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Szukaj użytkownika..." 
                        class="border rounded px-2 py-1">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                        Szukaj
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-2 py-2 border">
                                <a href="?sort=id&direction={{ $sort==='id' && $direction==='asc' ? 'desc':'asc' }}&search={{ $search ?? '' }}">
                                    ID {!! $sort==='id' ? ($direction==='asc' ? '↑' : '↓') : '' !!}
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a href="?sort=username&direction={{ $sort==='username' && $direction==='asc' ? 'desc':'asc' }}&search={{ $search ?? '' }}">
                                    Username {!! $sort==='username' ? ($direction==='asc' ? '↑' : '↓') : '' !!}
                                </a>
                            </th>
                            <th class="px-4 py-2 border">Rola</th>
                            <th class="px-4 py-2 border">
                                <a href="?sort=created_at&direction={{ $sort==='created_at' && $direction==='asc' ? 'desc':'asc' }}&search={{ $search ?? '' }}">
                                    Utworzono {!! $sort==='created_at' ? ($direction==='asc' ? '↑' : '↓') : '' !!}
                                </a>
                            </th>
                            <th class="px-4 py-2 border"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-2 border">{{ $user->id }}</td>
                                <td class="px-4 py-2 border">{{ $user->username }}</td>
                                <td class="px-4 py-2 border">{{ $user->role?->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->created_at->format('Y-m-d') }}</td>
                                <td class="px-4 py-2 border flex gap-2">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Edytuj
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('na pewno chcesz usunąć?')" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                            Usuń
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('users.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Dodaj użytkownika
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
