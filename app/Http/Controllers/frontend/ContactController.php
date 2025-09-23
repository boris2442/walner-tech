<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Models\Contact;

use Inertia\Inertia;

class ContactController extends Controller
{
  public function index()
  {
    return Inertia::render('Frontend/Contact');
  }
  public function store(ContactRequest $request)
  {
    // Création du contact
    Contact::create($request->validated());

    // Here you can handle the form submission, e.g., save to database or send an email

  return redirect()->back()->with('status', 'Votre message a été envoyé avec succès !');




  }
}
