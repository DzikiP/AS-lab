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

    public function myOrders()
    {
        return view('orders.my', [
            'orders' => request()->user()->orders()->with('status')->get()
        ]);
    }

    public function index()
    {
        return view('orders.index', [
            'orders' => Order::with(['client', 'status'])->get()
        ]);
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

        // 1. Walidacja
        $request->validate([
            'products' => 'required|array',
            'products.*' => 'integer|min:0'
        ]);

        // 2. Pobranie statusu "new"
        $status = OrderStatus::where('name', 'nowy')->firstOrFail();

        // 3. Utworzenie zamówienia
        $order = Order::create([
            'client_id' => $user->id,
            'status_id' => $status->id,
            'created_by' => $user->name,
            'updated_by' => $user->name,
        ]);

        // 4. Dodanie produktów (tylko z ilością > 0)
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
