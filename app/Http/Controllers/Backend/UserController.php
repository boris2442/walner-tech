<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function stats()
    {
        $totalUsers = User::count();
        $todayUsers = User::whereDate('created_at', Carbon::today())->count();

        return [
            'total' => $totalUsers,
            'today' => $todayUsers,
        ];
    }
    /**
     * Liste des utilisateurs + recherche
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Recherche par nom/email
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(10);

        return inertia('Backend/Users/UserIndex', [
            'users' => $users,
            'filters' => $request->only('search'),
            'stats' => $this->stats(), // 👈 ici tu fournis les stats
        ]);
    }

    /**
     * Formulaire création utilisateur
     */
    public function create()
    {
        return inertia('Backend/Users/Create');
    }

    /**
     * Sauvegarde nouvel utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,user',
        ]);

        // Génération mot de passe auto
        $password = 'Pass' . rand(1000, 9999);

        $user = User::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'role' => $request->role,
            'password' => Hash::make($password),
        ]);

        // TODO : Envoi email avec identifiants
        // Mail::to($user->email)->send(new NewUserCreatedMail($user, $password));

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès');
    }

    /**
     * Formulaire édition
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return inertia('Backend/Users/Edit', [
            'user' => $user
        ]);
    }

    /**
     * Mise à jour utilisateur
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,user',
        ]);

        $user->update($request->only('name', 'prenom', 'email', 'telephone', 'role'));

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès');
    }

    /**
     * Suppression utilisateur
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès');
    }
}
