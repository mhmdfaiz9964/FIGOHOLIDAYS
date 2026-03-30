<?php

namespace App\Http\Controllers;

use App\Models\HotelType;
use Illuminate\Http\Request;

class HotelTypeController extends Controller
{
    public function index()
    {
        $types = HotelType::latest()->paginate(20);
        return view('hotel-types.index', compact('types'));
    }

    public function create()
    {
        return view('hotel-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:hotel_types,name',
        ]);

        HotelType::create([
            'name' => $request->name,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('hotel-types.index')->with('success', 'Hotel type created successfully.');
    }

    public function edit(HotelType $hotelType)
    {
        return view('hotel-types.edit', compact('hotelType'));
    }

    public function update(Request $request, HotelType $hotelType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:hotel_types,name,' . $hotelType->id,
        ]);

        $hotelType->update([
            'name' => $request->name,
        ]);

        return redirect()->route('hotel-types.index')->with('success', 'Hotel type updated successfully.');
    }

    public function destroy(HotelType $hotelType)
    {
        $hotelType->delete();
        return redirect()->route('hotel-types.index')->with('success', 'Hotel type deleted successfully.');
    }
}
