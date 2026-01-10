<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $roleName = $user->role->name;

        return match ($roleName) {
            'admin' => view('dashboard.admin'),
            'worker' => view('dashboard.worker'),
            'client' => view('dashboard.client'),
            default => abort(403),
        };
    }
}
