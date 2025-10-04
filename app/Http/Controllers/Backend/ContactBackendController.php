<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Contact;
use Carbon\Carbon;

class ContactBackendController extends Controller
{
    public function index()
    {
        // Récupérer les messages (avec pagination si tu veux)
        $messages = Contact::latest()->get();


        // Total des messages enregistrés cette semaine
        $messagesThisWeek = Contact::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        return Inertia::render('Backend/Contacts/Contact', [
            'messages' => $messages,
            'totalMessages' => Contact::count(), // pour KPI
            'messagesThisWeek' => $messagesThisWeek, // 👈 KPI supplémentaire

        ]);
    }
}
