<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        return response()->json(Rating::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ratings,name',
            'value' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:20',
        ]);

        $rating = Rating::create([
            'name' => $request->name,
            'value' => $request->value,
            'color' => $request->color,
        ]);

        return response()->json(['status' => 'success', 'data' => $rating]);
    }
}
