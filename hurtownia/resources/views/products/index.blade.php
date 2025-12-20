<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produkty') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Nazwa</th>
                            <th class="px-4 py-2 border">Cena</th>
                            <th class="px-4 py-2 border">Ilość</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="px-4 py-2 border">{{ $product->id }}</td>
                                <td class="px-4 py-2 border">{{ $product->nazwa }}</td>
                                <td class="px-4 py-2 border">{{ $product->cena }}</td>
                                <td class="px-4 py-2 border">{{ $product->ilosc }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mb-4">
                <a href="{{ route('products.create') }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Dodaj produkt
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
