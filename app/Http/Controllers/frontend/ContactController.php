<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\NewContactMessageNotification;
use Illuminate\Support\Facades\Notification;


use Inertia\Inertia;

class ContactController extends Controller
{
  public function index()
  {
    return Inertia::render('frontend/Contact');
  }
  public function store(ContactRequest $request)
  {
    // Création du contact
    $contact = Contact::create($request->validated());

     // Enregistrement de la notification directement dans la base
    Notification::sendNow($contact, new NewContactMessageNotification($contact));
    // Here you can handle the form submission, e.g., save to database or send an email

    return redirect()->back()->with('status', 'Votre message a été envoyé avec succès !');




  }
}
