<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roleName = $user->role->name;

        return match ($roleName) {
            'admin' => view('dashboard.admin'),
            'worker' => view('dashboard.worker', [
                'products' => Product::select('id', 'nazwa', 'cena')->take(5)->get(),
                'orders' => Order::with(['client', 'status'])->latest()->take(5)->get(),
            ]),
            'client' => view('dashboard.client', [
                'myOrdersCount' => $user->orders()->count(),
                'pendingOrdersCount' => $user->orders()
                    ->whereHas('status', fn($q) => $q->where('name', 'w trakcie realizacji'))
                    ->count(),
                'products' => Product::all(),
            ]),
            default => abort(403),
        };
    }
}
