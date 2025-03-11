<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;

class DashboardController extends Controller
{
    public function index()
    {
        $modules = Module::with('readings')->get();
        // dd($modules);
        return view('dashboard', compact('modules'));
    }
}
