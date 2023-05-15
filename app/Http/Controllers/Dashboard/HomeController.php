<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super|admin');
    }

    public function index(): \Inertia\Response
    {  
       return Inertia::render('home/home_index');
    }
}
