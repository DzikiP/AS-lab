<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Wszystkie zamówienia
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Klient</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Data</th>
                        <th class="px-4 py-2 border">Akcja</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td class="px-4 py-2 border">{{ $order->id }}</td>
                        <td class="px-4 py-2 border">{{ $order->client->username }}</td>
                        <td class="px-4 py-2 border">{{ $order->status->name }}</td>
                        <td class="px-4 py-2 border">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('orders.edit', $order) }}"
                               class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Zmień status
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
