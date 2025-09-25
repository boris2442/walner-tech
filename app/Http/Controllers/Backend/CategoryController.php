<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Http\Requests\Backend\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function create()
    {
        return Inertia::render('Backend/Categories/CategoryCreate');
    }
    public function store(CategoryRequest $request)
    {
        try {
            Category::create($request->validated());

            return redirect()->route('categories.index')
                ->with('success', 'Catégorie ajoutée avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue !');
        }
    }

    public function index()
    {
        $categories = Category::all();
        return Inertia::render('Backend/Categories/CategoryIndex', compact('categories'));
    }
}
