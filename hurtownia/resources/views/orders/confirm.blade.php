<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Podsumowanie zamówienia
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded overflow-x-auto">

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <input type="hidden" name="confirm" value="1">

                <table class="w-full border-collapse table-fixed">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Produkt</th>
                            <th class="text-left py-2">Cena</th>
                            <th class="text-left py-2">Ilość</th>
                            <th class="text-left py-2">J. m.</th>
                            <th class="text-left py-2">Suma</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($products as $product)
                            @php
                                $qty = $productsData[$product->id]['quantity'];
                                $sum = $qty * $product->price;
                                $total += $sum;
                            @endphp
                            <tr class="border-b">
                                <td class="py-2">{{ $product->name }}</td>
                                <td class="py-2">{{ number_format($product->price, 2) }} zł</td>
                                <td class="py-2">{{ $qty }}</td>
                                <td class="py-2">{{ $product->unit }}</td>
                                <td class="py-2">{{ number_format($sum, 2) }} zł</td>
                                <input type="hidden" name="products[{{ $product->id }}]" value="{{ $qty }}">
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right font-bold py-2">Łącznie:</td>
                            <td class="font-bold py-2">{{ number_format($total, 2) }} zł</td>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-6 flex justify-end gap-2">
                    <a href="{{ route('orders.create') }}" class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                        Cofnij
                    </a>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Złóż zamówienie
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
