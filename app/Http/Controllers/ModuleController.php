<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModuleReading;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('readings')->get();
        return view('dashboard', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'status' => 'required|in:Active,Inactive,Malfunction',
        ]);

        Module::create([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ]);
        return redirect()->back()->with('success', 'Module Added Successfully');
    }

    public function fetchModules()
    {
        $modules = Module::with('readings')->get();
        return response()->json($modules);
    }

    public function create()
    {
        return view('Modules.Create');
    }

    public function chart()
    {
        $modules = Module::with(['readings' => function ($query) {
            $query->latest()->take(20)->orderBy('timestamp', 'desc');
        }])->get();

        // dd($modules);
        return view('Modules.Chart', compact('modules'));
    }

}
