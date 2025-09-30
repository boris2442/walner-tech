<?php

namespace App\Http\Controllers\frontend;
use App\Traits\HasSeo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {

        return Inertia::render('Frontend/HomePage')
      
            ;
    }


    //   public function index()
    // {
    //      use HasSeo;
    //     return Inertia::render('Frontend/HomePage', [
    //         'seo' => $this->seo(
    //             'Walner Tech - Accueil',
    //             'Walner Tech : boutique en ligne de PC, accessoires et produits électroniques modernes.',
    //             'Walner Tech, PC, accessoires, électronique'
    //         ),
    //         'auth' => [
    //             'user' => auth()->user(),
    //         ],
    //     ]);
    // }
}
