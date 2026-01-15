<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create', [
            'products' => Product::all()
        ]);
    }

    public function myOrders(Request $request)
    {
        $user = $request->user();
        $query = $user->orders()->with(['status', 'products']);

        // Wyszukiwanie 
        if ($request->filled('search')) {
            $query->where('id', $request->search);
        }

        // Sortowanie
        if ($request->filled('sort')) {
            $direction = $request->direction === 'asc' ? 'asc' : 'desc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $orders = $query->paginate(10);
        $statuses = OrderStatus::all();

        return view('orders.my', compact('orders', 'statuses'));
    }


    public function index(Request $request)
    {
        $query = Order::with(['client', 'status']);

        // wyszukiwanie po ID lub kliencie
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('id', $search)
                ->orWhereHas('client', fn($q) => $q->where('username', 'like', "%$search%"));
        }

        // filtr po statusie
        if ($request->filled('status')) {
            $query->where('status_id', $request->status);
        }

        // sortowanie
        if ($request->filled('sort')) {
            $direction = $request->direction === 'asc' ? 'asc' : 'desc';
            if ($request->sort === 'client') {
                $query->join('users', 'orders.client_id', '=', 'users.id')
                    ->orderBy('users.username', $direction)
                    ->select('orders.*');
            } else {
                $query->orderBy($request->sort, $direction);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $orders = $query->paginate(10);

        $statuses = OrderStatus::all();

        return view('orders.index', compact('orders', 'statuses'));
    }



    public function edit(Order $order)
    {
        return view('orders.edit', [
            'order' => $order,
            'statuses' => OrderStatus::all()
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'products' => 'required|array',
            'products.*' => 'integer|min:0'
        ]);

        $status = OrderStatus::where('name', 'nowy')->firstOrFail();

        $order = Order::create([
            'client_id' => $user->id,
            'status_id' => $status->id,
            'created_by' => $user->name,
            'updated_by' => $user->name,
        ]);

        foreach ($request->products as $productId => $quantity) {
            if ($quantity > 0) {
                $order->products()->attach($productId, [
                    'quantity' => $quantity
                ]);
            }
        }

        return redirect()
            ->route('orders.my')
            ->with('success', 'Zamówienie zostało złożone');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status_id' => 'exists:order_statuses,id'
        ]);

        $order->update([
            'status_id' => $request->status_id
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Status zamówienia został zaktualizowany');
    }
}
