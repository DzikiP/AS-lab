<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nowe zamówienie
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

            <form method="POST" action="{{ route('orders.store') }}" id="orderForm">
                @csrf

            <table class="w-full border-collapse table-fixed">
                <thead>
                    <tr class="border-b">
                        <th class="w-1/2 text-left py-2">Produkt</th>
                        <th class="w-1/6 text-left py-2">Cena</th>
                        <th class="w-1/6 text-left py-2">Ilość</th>
                        <th class="w-1/6 text-left py-2">Suma</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-b">
                            <td class="py-2">{{ $product->nazwa }}</td>
                            <td class="py-2">{{ $product->cena }} zł</td>
                            <td class="py-2">
                                <input type="number"
                                    name="products[{{ $product->id }}]"
                                    data-price="{{ $product->cena }}"
                                    value="0"
                                    min="0"
                                    class="quantity w-20 border rounded px-2 py-1">
                            </td>
                            <td class="py-2 sum">0 zł</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right font-bold py-2">Łącznie:</td>
                        <td id="totalPrice" class="font-bold py-2">0 zł</td>
                    </tr>
                </tfoot>
            </table>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Podsumuj zamówienie
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const quantities = document.querySelectorAll('.quantity');
        const totalPriceEl = document.getElementById('totalPrice');

        function updateSums() {
            let total = 0;
            quantities.forEach(input => {
                const price = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value) || 0;
                const sum = price * quantity;
                input.closest('tr').querySelector('.sum').innerText = sum.toFixed(2) + ' zł';
                total += sum;
            });
            totalPriceEl.innerText = total.toFixed(2) + ' zł';
        }

        quantities.forEach(input => {
            input.addEventListener('input', updateSums);
        });

        updateSums();
    </script>
</x-app-layout>
