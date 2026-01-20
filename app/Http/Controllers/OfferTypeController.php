<?php

namespace App\Http\Controllers;

use App\Models\OfferType;
use Illuminate\Http\Request;

class OfferTypeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:offer_types,name',
        ]);

        $type = OfferType::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $type
        ]);
    }

    public function index()
    {
        return response()->json(OfferType::all());
    }
}
