<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Modules\Enseignement\Entities\Niveau;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        // dd(Niveau::all());
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            //code...
            // dump('$request:', $request);
            // dd('$request33', $request);
            $user = User::where('username', $request->username)->first();
           

            if($user){
                $request->authenticate();
                $request->session()->regenerate();
                return redirect()->intended(RouteServiceProvider::HOME);
            }
            else{
                return redirect('/login')->with('message', [
                    'type' => 'error',
                    'text' =>  'Identifiants incorrects!',
                ]);
            }   
            
        } catch (\Throwable $th) {
            //throw $th;
            // dd('error:', $th, $th->getMessage());
            if ($th->getMessage() == "These credentials do not match our records.") {
                return redirect('/login')->with('message', [
                    'type' => 'error',
                    'text' =>  'Identifiants incorrects!',
                ]);
            }
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Erreur.Données invalides ou erronées!',
            ]);
        }
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
