<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        return response()->json(Province::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:provinces,name',
        ]);

        $province = Province::create($request->all());

        return response()->json([
            'success' => true,
            'province' => $province
        ]);
    }
}
