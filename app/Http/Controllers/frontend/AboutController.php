<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutController extends Controller
{
    public function index()
    {

        return Inertia::render('frontend/About', [
            'data' => [
                'title' => 'A propos de Walner Tech ',
                'description' => 'Découvrez Walner Tech à Bafoussam et Yaoundé : ordinateurs portables, PC de bureau, smartphones et accessoires informatiques de qualité au meilleur prix au Cameroun.',
                 'image' => asset('walner.jpg'),
                'url' => url('/about'),
                'robots' => 'index, follow',
            ],
        ])  ;

      
    }
}
