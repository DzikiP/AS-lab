<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Użytkownicy
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex gap-2">
                <form method="GET" class="flex gap-2 items-center">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Szukaj użytkownika..." 
                        class="border rounded px-8 py-1">

                    <select name="role_id" class="border rounded px-6 py-1">
                        <option value="">Wszystkie role</option>
                        @foreach($roles as $role)
                            @if($role->name !== 'admin')
                                <option value="{{ $role->id }}" @selected(request('role_id') == $role->id)>
                                    {{ $role->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>

                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                        Filtruj
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-2 py-2 border">
                                <a href="{{ route('users.index', ['sort'=>'id','direction'=>($sort==='id' && $direction==='asc')?'desc':'asc','search'=>$search ?? '', 'role_id'=>request('role_id')]) }}">
                                    ID {!! $sort==='id'?($direction==='asc'?'↑':'↓') : '' !!}
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a href="{{ route('users.index', ['sort'=>'username','direction'=>($sort==='username' && $direction==='asc')?'desc':'asc','search'=>$search ?? '', 'role_id'=>request('role_id')]) }}">
                                    Username {!! $sort==='username'?($direction==='asc'?'↑':'↓') : '' !!}
                                </a>
                            </th>
                            <th class="px-4 py-2 border">Rola</th>
                            <th class="px-4 py-2 border">
                                <a href="{{ route('users.index', ['sort'=>'created_at','direction'=>($sort==='created_at' && $direction==='asc')?'desc':'asc','search'=>$search ?? '', 'role_id'=>request('role_id')]) }}">
                                    Utworzono {!! $sort==='created_at'?($direction==='asc'?'↑':'↓') : '' !!}
                                </a>
                            </th>
                            <th class="px-4 py-2 border">Akcje</th>
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
                                    <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Edytuj</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Na pewno chcesz usunąć?')" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Usuń</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Dodaj użytkownika
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
