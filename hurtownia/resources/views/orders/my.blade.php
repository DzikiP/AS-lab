<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moje zamówienia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('orders.my') }}" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Szukaj po ID"
                       class="border px-3 py-1 rounded flex-1">
                <button type="submit" class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Szukaj                    
                </button>
            </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">
                                <a href="{{ route('orders.my', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID
                                </a>
                            </th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">
                                <a href="{{ route('orders.my', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Data
                                </a>
                            </th>
                            <th class="px-4 py-2 border">Produkty</th>
                            <th class="px-4 py-2 border">Suma</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="px-4 py-2 border">{{ $order->id }}</td>
                                <td class="px-4 py-2 border">{{ $order->status->name }}</td>
                                <td class="px-4 py-2 border">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2 border">
                                    <ul>
                                        @foreach($order->products as $product)
                                            <li>{{ $product->nazwa }} ({{ $product->pivot->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-4 py-2 border">
                                    {{ number_format($order->total_price, 2) }} zł
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $orders->withQueryString()->links() }}
                </div>

                <div class="mt-4">
                    <a href="{{ route('orders.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md 
                              font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 
                              focus:ring-offset-2 focus:ring-blue-500">
                        Złóż nowe zamówienie
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
