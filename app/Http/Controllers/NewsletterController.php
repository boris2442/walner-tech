<?php
namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Newsletter;
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

    public function index()
    {
        // $newsletterList = NewsLetter::all();
        $newsletterList = NewsLetter::query()
            ->orderBy('created_at', 'desc')
            ->get();
        $totalEmailNewsletter = NewsLetter::count();

        return Inertia::render('backend/newsletters/NewsLetter', [
            'newsletterList' => $newsletterList,
            'totalEmailNewsletter' => $totalEmailNewsletter,
        ]);
    }
}
