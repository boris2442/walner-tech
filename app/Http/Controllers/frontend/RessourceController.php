<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RessourceController extends Controller
{
   public function cgu()
   {
      return Inertia::render('frontend/Cgu');
   }
   public function politiqueDeConfidentialite()
   {
      return Inertia::render('frontend/Privacy');
   }
   public function mentionsLegales()
   {
      return Inertia::render('frontend/Mentionlegale');
   }
   public function noRemboursement()
   {
      return Inertia::render('frontend/Noremboursement');
   }
   public function faq(){
      return Inertia::render('frontend/Faq');
   }
}
