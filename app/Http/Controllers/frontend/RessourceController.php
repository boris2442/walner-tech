<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RessourceController extends Controller
{
   public function cgu()
   {
      return Inertia::render('frontend/Cgu', [
         'seo' => [
            'title' => 'Conditions Générales d’Utilisation (CGU) – Walner Tech',
            'description' => 'Consultez les Conditions Générales d’Utilisation de Walner Tech. Découvrez vos droits et obligations lors de l’utilisation de notre site et services en ligne au Cameroun.',
            'image' => asset('walner.jpg'), // image pour partage social
            'url' => url('/ressources/cgu'),
            'robots' => 'index, follow',
         ],
      ]);
   }
   public function politiqueDeConfidentialite()
   {
      return Inertia::render('frontend/Privacy', [
         'seo' => [
            'title' => ' Politique de confidentialité -Walner Tech',
            'description' => 'Découvrez comment Walner Tech protège vos données personnelles et votre vie privée lorsque vous utilisez nos services et notre site.',
            'image' => asset('walner.jpg'),
            'url' => url('/ressources/confidentialite'),
            'robots' => 'index, follow',
         ],
      ]);
   }
   public function mentionsLegales()
   {
      return Inertia::render('frontend/Mentionlegale', [
         'seo' => [
            'title' => '  Mentions légales- Walner Tech',
            'description' => 'Toutes les informations légales concernant Walner Tech, y compris le responsable de publication et les conditions d’utilisation du site.',
            'image' => asset('walner.jpg'),
            'url' => url('/ressources/legales'),
            'robots' => 'index, follow',
         ],
      ]);
   }
   public function noRemboursement()
   {
      return Inertia::render('frontend/Noremboursement', [
         'seo' => [
            'title' => 'Walner Tech - Politique de non-remboursement ',
            'description' => 'Consultez la politique de non-remboursement de Walner Tech pour comprendre les conditions d’achat et d’échange de nos produits.',
            'image' => asset('walner.jpg'),
            'url' => url('/ressources/refundpolicy'),
            'robots' => 'index, follow',
         ],
      ]);
   }
   public function faq()
   {
      return Inertia::render('frontend/Faq', [
         'seo' => [
            'title' => ' FAQ – Questions fréquentes - Walner Tech  ',
            'description' => 'Trouvez rapidement les réponses aux questions les plus fréquentes concernant nos produits, services et commandes chez Walner Tech.',
            'image' => asset('walner.jpg'),
            'url' => url('/ressources/faq'),
            'robots' => 'index, follow',
         ],
      ]);
   }
}
