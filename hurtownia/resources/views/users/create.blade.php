<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodaj użytkownika') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="username" class="block mb-1">Username</label>
                        <input type="text" name="username" id="username" class="w-full border rounded px-3 py-2" value="{{ old('username') }}">
                        @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block mb-1">Hasło</label>
                        <input type="password" name="password" id="password" class="w-full border rounded px-3 py-2">
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block mb-1">Powtórz hasło</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label for="role_id" class="block mb-1">Rola</label>
                        <select name="role_id" id="role_id" class="w-full border rounded px-3 py-2">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Dodaj użytkownika
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
