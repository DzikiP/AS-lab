<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Obsługa żądania HTTP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  // Wymagana rola użytkownika
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Jeśli niezalogowany → przekierowanie do logowania
        if (!$user) {
            return redirect()->route('login');
        }

        // Sprawdzenie roli
        if (!$user->hasRole($role)) {
            abort(403, 'Brak uprawnień do wykonania tej akcji.');
        }

        return $next($request);
    }
}
