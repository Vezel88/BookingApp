<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Studio;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function daftar()
    {
        $studios = Studio::all();
        return view('daftarstudio', compact('studios'));
    }

    public function show($id)
    {
        $studio = Studio::with('studioTimes')->findOrFail($id);

        $dates = collect([]);
        for ($i = 0; $i < 7; $i++) {
            $dates->push(now()->addDays($i));
        }

        return view('detailstudio', compact('studio', 'dates'));
    }
}
