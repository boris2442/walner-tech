<?php

namespace App\Http\Controllers\Frontend;
use App\Traits\HasSeo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {

        return Inertia::render('frontend/HomePage')

        ;
    }



}
