<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        switch (auth()->user()->roles[0]->name) {
            case 'admin':
                return redirect()->intended(route('predictions.index'));
            case 'psychologist':
                return redirect()->intended(route('predictions.list'));
            default:
                return redirect()->intended(route('stress.form'));
        }
        // return redirect()->intended(route('predictions.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function redirectTo()
    {
        if (auth()->user()->hasRole('admin')) {
            return route('users.index');
        }

        if (auth()->user()->hasRole('psychologist')) {
            return route('predictions.list');
        }

        return route('stress.form');
    }
}
