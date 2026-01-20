<?php

namespace App\Http\Controllers;

use App\Models\HotelType;
use Illuminate\Http\Request;

class HotelTypeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:hotel_types,name',
        ]);

        $type = HotelType::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'type' => $type
        ]);
    }
}
