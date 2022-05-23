<?php

namespace {{ namespace }}\Http\Controllers\Auth;

use {{ namespace }}\Ui\Page;
use {{ namespace }}\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @param  Page $page
     * @return Page
     */
    public function create(Page $page)
    {
        return $page
            ->page('Auth/Login')
            ->with('submit-route', route('{{ name }}.login'))
            ->with('forgot-password-route', route('{{ name }}.password.request'))
            ->with('lang', [
                'email'           => 'E-Mail',
                'password'        => 'Passwort',
                'remember'        => 'Eingeloggt bleiben',
                'login'           => 'Anmelden',
                'forgot_password' => 'Passwort vergessen?',
            ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::{{ home-const }});
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request          $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('{{ name }}')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
