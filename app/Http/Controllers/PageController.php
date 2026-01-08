<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function welcome() {
        return Inertia::render('Welcome');
    }

    public function about() {
        return Inertia::render('site/About');
    }
}
