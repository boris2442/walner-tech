<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RessourceController extends Controller
{
   public function cgu(){
    return Inertia::render('Frontend/Cgu');
   }
   public function politiqueDeConfidentialite(){
    return Inertia::render('Frontend/Privacy');
   }
   public function mentionsLegales(){
    return Inertia::render('Frontend/Mentionlegale');
   }
   public function noRemboursement(){
    return Inertia::render('Frontend/Noremboursement');
   }
}
