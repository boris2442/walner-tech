<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUserRegistered;
//importatation des logs


class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:20'],
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Créer l'utilisateur avec rôle explicite
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user', // rôle explicite
        ]);

        // Recharger les données depuis la DB (optionnel ici car role défini)
        $user->refresh();

        // Récupérer tous les admins
        $admins = User::where('role', 'admin')->get();

        // Envoyer la notification aux admins
        Notification::send($admins, new NewUserRegistered($user));

        // Déclencher l'événement Registered
        event(new Registered($user));

        // Connecter l'utilisateur automatiquement
        Auth::login($user);
        
        return to_route('dashboard')->with('flash', [
            'message' => '👋 Bienvenue ' . $user->name . '!',
            'link' => [
                'text' => '🔙 Retour à l’accueil',
                'href' => route('home')
            ]
        ]);

    }
}
