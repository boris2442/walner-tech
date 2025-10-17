<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Http\Requests\Backend\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function create()
    {
        return Inertia::render('backend/categories/CategoryCreate');
    }
    public function store(CategoryRequest $request)
    {
        try {
            Category::create($request->validated());

            return redirect()->route('categories.index')
                //  ->with('success', 'Catégorie ajoutée avec succès !');
                ->with(
                    'flash',
                    [
                        'message' => 'Catégorie ajoutée avec succès !',
                        'text' => 'Ajouter un autre',
                        'href' => route('categories.create')
                    ]
                );


        } catch (\Exception $e) {
            return redirect()->back()
                // ->with('error', 'Une erreur est survenue !');

                ->with(
                    'flash',
                    [
                        'message' => 'Une erreur est survenue !',
                        // 'text' => '',
                        //'href' => route('')
                    ]
                );
        }
    }

    public function index()
    {
        $categories = Category::all();
        return Inertia::render('backend/categories/CategoryIndex', compact('categories'));
    }

    public function stats()
    {
        // Nombre total de catégories
        $totalCategories = Category::count();

        // Nombre de catégories actives
        $activeCategories = Category::where('status', true)->count();

        // Nombre de catégories inactives
        $inactiveCategories = Category::where('status', false)->count();

        // Retour via Inertia
        return Inertia::render('Admin/Categories/Stats', [
            'stats' => [
                'total' => $totalCategories,
                'active' => $activeCategories,
                'inactive' => $inactiveCategories,
            ]
        ]);
    }


    // public function indexBackend()

    // {
    //     $stats = [
    //         'total' => Category::count(),
    //     ];
    //     $categories = Category::query()
    //         ->when(request('search'), fn($q) => $q->where('name', 'like', '%' . request('search') . '%'))
    //         ->orderBy('created_at', 'desc')
    //         ->get(); 

    //     return Inertia::render('Backend/Categories/CategoryIndex', [
    //         'stats' => $stats,
    //         'categories' => $categories,
    //     ]);
    // }


    public function indexBackend()
    {
        $stats = [
            'total' => Category::count(),
        ];

        $categories = Category::query()
            ->when(request('search'), fn($q) => $q->where('name', 'like', '%' . request('search') . '%'))
            ->orderBy('created_at', 'desc')
            ->get(); // pas de pagination

        return Inertia::render('backend/categories/CategoryIndex', [
            'stats' => $stats,
            'categories' => $categories,
        ]);
    }
    // public function destroy($id)
    // {
    //     $category = Category::find($id);

    //     if (!$category) {
    //         return redirect()->back()->with('error', 'Catégorie introuvable.');
    //     }

    //     $category->delete();


    //     return redirect()->route('categories.index');
    // }


    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->back()
                //->with('error', 'Catégorie introuvable.');
                ->with(
                    'flash',
                    [
                        'message' => 'Catégorie introuvable.',
                        //'text' => 'Ajouter un autre',
                        //'href' => route('admin.products.create')
                    ]
                );
        }

        $category->delete();

        // Redirection compatible Inertia
        return Inertia::location(route('categories.index'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return inertia('backend/categories/Edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')
            //->with('success', 'Catégorie mise à jour avec succès.');
            ->with(
                'flash',
                [
                    'message' => 'Catégorie mise à jour avec succès.',
                    //'text' => 'Ajouter un autre',
                    //'href' => route('admin.products.create')
                ]
            );
    }

}
