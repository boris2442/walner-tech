<?php
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Newsletter;
// use Illuminate\Support\Facades\Validator;

// class NewsletterController extends Controller
// {
//  public function store(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'email' => 'required|email|unique:newsletters,email',
//     ]);

//     if ($validator->fails()) {
//         return back()->withErrors($validator)->with('error', 'Adresse email invalide ou déjà utilisée.');
//     }

//     Newsletter::create(['email' => $request->email]);

//     return back()->with('success', 'Merci pour votre abonnement 🎉');
// }


// }




namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email',
        ]);

        if ($validator->fails()) {
            return back()->with('flash', [
                'type' => 'error',
                'message' => 'Adresse email invalide ou déjà inscrite.',
            ]);
        }

        // Enregistrer l’email
        \DB::table('newsletters')->insert([
            'email' => $request->email,
            'created_at' => now(),
        ]);

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Merci pour votre abonnement ! 🎉',
        ]);
    }
}
