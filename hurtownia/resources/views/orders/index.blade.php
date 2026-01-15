<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Wszystkie zamówienia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="GET" action="{{ route('orders.index') }}" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Szukaj po ID lub kliencie"
                           class="border px-3 py-1 rounded flex-1">

                    <select name="status" onchange="this.form.submit()" class="border px-8 py-1 rounded">
                        <option value="">Wszystkie statusy</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" @selected(request('status') == $status->id)>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Filtruj
                    </button>
                </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <table class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">
                                <a href="{{ route('orders.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a href="{{ route('orders.index', array_merge(request()->all(), ['sort' => 'client', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Klient
                                </a>
                            </th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">
                                <a href="{{ route('orders.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Data
                                </a>
                            </th>
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
                                <td class="px-4 py-2 border flex gap-2">
                                    <a href="{{ route('orders.edit', $order) }}"
                                       class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Zmień status
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $orders->withQueryString()->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
