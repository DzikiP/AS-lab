<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edytuj użytkownika
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" class="w-full border rounded px-3 py-2" value="{{ old('username', $user->username) }}" required>
                        @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Nowe hasło (opcjonalnie)</label>
                        <input type="password" name="password" class="w-full border rounded px-3 py-2">
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Powtórz nowe hasło</label>
                        <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Rola</label>
                        <select name="role_id" class="w-full border rounded px-3 py-2" required>
                            <option value="">Wybierz rolę</option>
                            @foreach($roles as $role)
                                @if($role->name !== 'admin')
                                    <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>
                                        {{ $role->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('role_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Zapisz zmiany
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
