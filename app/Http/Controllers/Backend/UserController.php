<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected function getRolesEnum(): array
    {
        $column = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'");

        if (!isset($column[0])) {
            return [];
        }

        $type = $column[0]->Type ?? '';

        preg_match("/^enum\('(.*)'\)$/", $type, $matches);

        return isset($matches[1]) ? explode("','", $matches[1]) : [];
    }

    public function stats()
    {
        $totalUsers = User::count();
        $todayUsers = User::whereDate('created_at', Carbon::today())->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalClients = User::where('role', 'user')->count(); // ou 'client' selon ton rôle
        $weekUsers = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();


        return [
            'total' => $totalUsers,
            'today' => $todayUsers,
            'admins' => $totalAdmins,
            'clients' => $totalClients,
            'week' => $weekUsers,
        ];
    }
    /**
     * Liste des utilisateurs + recherche
     */
    public function index(Request $request)
    {
        $query = User::query();
        $roles = $this->getRolesEnum();
        // Recherche par nom/email
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('role', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(70);
        // dd($roles);

        return inertia('backend/users/UserIndex', [
            'auth' => [
                'user' => Auth::user(), // <-- doit être un objet User
            ],
            'users' => $users,
            'filters' => $request->only('search'),
            'stats' => $this->stats(), // 👈 ici tu fournis les stats
            'roles' => $roles, // 👈 on envoie les rôles dynamiques
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $roles = $this->getRolesEnum();

        $request->validate([
            'role' => 'required|in:' . implode(',', $roles),
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->back()
            //->with('success', 'Rôle mis à jour avec succès');

            ->with(
                'flash',
                [
                    'message' => 'Rôle mis à jour avec succès',
                    // 'text' => '',
                    //'href' => route('')
                ]
            );
    }



    // public function updateRole(Request $request, User $user)
    // {
    //     $roles = $this->getRolesEnum();

    //     $request->validate([
    //         'role' => 'required|in:' . implode(',', $roles),
    //     ]);

    //     $user->role = $request->role;
    //     $user->save();

    //     return response()->json([
    //         'message' => 'Rôle mis à jour avec succès',
    //         'user' => $user,
    //     ]);
    // }

    /**
     * Formulaire création utilisateur




    */
    public function create()
    {
        return inertia('backend/users/Create');
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

        return redirect()->route('users.index')

            //->with('success', 'Utilisateur créé avec succès');
            ->with(
                'flash',
                [
                    'message' => 'Utilisateur créé avec succès',
                    // 'text' => '',
                    //'href' => route('')
                ]
            );



    }

    /**
     * Formulaire édition
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return inertia('backend/users/Edit', [
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

        return redirect()->route('users.index')
            // ->with('success', 'Utilisateur mis à jour avec succès');

            ->with(
                'flash',
                [
                    'message' => 'Utilisateur mis à jour avec succès',
                    // 'text' => '',
                    //'href' => route('')
                ]
            );
    }

    /**
     * Suppression utilisateur
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            //->with('success', 'users mise à jour avec succès.');
            ->with(
                'flash',
                [
                    'message' => 'Utilisateur supprimé avec succès',
                    // 'text' => '',
                    //'href' => route('')
                ]
            );
    }
}
