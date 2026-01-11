<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nowe zamówienie
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

            {{-- komunikaty błędów --}}
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Produkt</th>
                            <th class="text-left py-2">Cena</th>
                            <th class="text-left py-2">Ilość</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-b">
                                <td class="py-2">{{ $product->nazwa }}</td>
                                <td class="py-2">{{ $product->cena }} zł</td>
                                <td class="py-2">
                                    <input
                                        type="number"
                                        name="products[{{ $product->id }}]"
                                        min="0"
                                        value="0"
                                        class="w-24 border rounded px-2 py-1"
                                    >
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 flex justify-end">
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Złóż zamówienie
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
