<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moje zamówienia
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Data</th>
                        <th class="px-4 py-2 border">Produkty</th>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                <a href="{{ route('orders.create') }}" 
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md 
                        font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2                                 focus:ring-offset-2 focus:ring-blue-500">
                        Złóż nowe zamówienie
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
