<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edytuj Produkt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('products.update', $product->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nazwa</label>
                        <input type="text" name="nazwa" class="w-full border rounded px-3 py-2" value="{{ old('nazwa', $product->nazwa) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Opis</label>
                        <textarea name="opis" class="w-full border rounded px-3 py-2">{{ old('opis', $product->opis) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Cena</label>
                        <input type="number" step="0.01" name="cena" class="w-full border rounded px-3 py-2" value="{{ old('cena', $product->cena) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Ilosc</label>
                        <input type="number" name="ilosc" class="w-full border rounded px-3 py-2" value="{{ old('ilosc', $product->ilosc) }}" required>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Edytuj produkt
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
