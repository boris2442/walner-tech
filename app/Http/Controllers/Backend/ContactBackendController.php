<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Contact;

class ContactBackendController extends Controller
{
    public function index()
    {
        // Récupérer les messages (avec pagination si tu veux)
        $messages = Contact::latest()->get();

        return Inertia::render('Backend/Contacts/Contact', [
            'messages' => $messages,
            'totalMessages' => Contact::count(), // pour KPI
        ]);
    }
}
