<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edytuj zamówienie #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto bg-white p-6 shadow rounded">

            <p class="mb-4"><strong>Klient:</strong> {{ $order->client->username }}</p>
            <p class="mb-4"><strong>Status obecny:</strong> {{ $order->status->name }}</p>

            <form method="POST" action="{{ route('orders.updateStatus', $order) }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="status_id" class="block mb-1">Nowy status</label>
                    <select name="status_id" id="status_id" class="w-full border rounded px-3 py-2">
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" @selected($order->status_id == $status->id)>{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Zapisz zmiany
                </button>
            </form>

            <div class="mt-6">
                <h3 class="font-bold mb-2">Produkty w zamówieniu</h3>
                <ul class="list-disc pl-5">
                    @foreach($order->products as $product)
                        <li>{{ $product->name }} - {{ $product->pivot->quantity }} szt.</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
