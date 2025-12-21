<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Name</label>
                        <input type="text" name="nazwa" class="w-full border rounded px-3 py-2" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Description</label>
                        <textarea name="opis" class="w-full border rounded px-3 py-2">{{ old('title') }}"</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Price</label>
                        <input type="number" step="0.01" name="cena" class="w-full border rounded px-3 py-2" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Stock</label>
                        <input type="number" name="ilosc" class="w-full border rounded px-3 py-2" value="{{ old('title') }}" required>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Dodaj produkt
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
