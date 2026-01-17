<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dodaj produkt
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Nazwa</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Opis</label>
                        <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Cena</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Ilość</label>
                        <input type="number" name="quantity" value="{{ old('quantity') }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Jednostka miary</label>
                        @php
                            $units = ['szt.', 'kg', 'l', 'm', 'm.b', 'op.'];
                        @endphp
                        <select name="unit" class="w-full border rounded px-3 py-2">
                            <option value="">Wybierz jednostkę</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit }}" {{ old('unit') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Dodaj produkt
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
