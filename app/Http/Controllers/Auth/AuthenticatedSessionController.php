<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Console\View\Components\Alert;

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

        $id = Auth::user()->id;
        $data = User::find($id);
        $username = $data->name;


        $request->session()->regenerate();

        $notification = array(
        'message' => 'User '.$username.' Login Successfully',
        'alert-type' => 'info'
        );

        $url = '';
        if($request->user()->role === 'admin'){
            $url = 'admin/dashboard';
        }
        elseif($request->user()->role === 'agent'){
            $url = 'agent/dashboard';
        }
        elseif($request->user()->role === 'user'){
            $url = '/dashboard';
        }

        return redirect()->intended($url)->with($notification);
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
}