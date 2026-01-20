<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    private function getSriLankanCities()
    {
        return [
            "Colombo", "Kandy", "Galle", "Jaffna", "Negombo", "Anuradhapura", "Ratnapura", "Badulla", 
            "Matara", "Trincomalee", "Batticaloa", "Dambulla", "Kurunegala", "Nuwara Eliya", "Kalutara", 
            "Bentota", "Hikkaduwa", "Ella", "Polonnaruwa", "Sigiriya", "Unawatuna", "Mirissa", "Arugam Bay",
            "Pinnawala", "Tangalle", "Weligama", "Pasikuda", "Beruwala", "Wattala", "Dehiwala-Mount Lavinia",
            "Kotte", "Vavuniya", "Mannar", "Mullaitivu", "Kilinochchi", "Hambantota", "Matale", "Gampaha",
            "Kegalle", "Moneragala", "Puttalam", "Ampara"
        ];
    }

    public function index(Request $request)
    {
        $query = Hotel::with('hotelType');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
        }

        $hotels = $query->latest()->paginate(10);
        return view('hotels.index', compact('hotels'));
    }

    public function create()
    {
        $hotelTypes = HotelType::all();
        $cities = $this->getSriLankanCities();
        return view('hotels.create', compact('hotelTypes', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'price_per_night' => 'required|numeric|min:0',
            'meta_description' => 'nullable|string',
            'hotel_type_id' => 'required|exists:hotel_types,id',
            'activities' => 'nullable|array',
            'image' => 'nullable|image|max:5120',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['image', 'activities']);
            $data['activities'] = $request->activities;

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('hotels', 'public');
            }

            Hotel::create($data);

            DB::commit();
            return redirect()->route('hotels.index')->with('success', 'Hotel added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit(Hotel $hotel)
    {
        $hotelTypes = HotelType::all();
        $cities = $this->getSriLankanCities();
        return view('hotels.edit', compact('hotel', 'hotelTypes', 'cities'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'price_per_night' => 'required|numeric|min:0',
            'meta_description' => 'nullable|string',
            'hotel_type_id' => 'required|exists:hotel_types,id',
            'activities' => 'nullable|array',
            'image' => 'nullable|image|max:5120',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['image', 'activities', '_token', '_method']);
            $data['activities'] = $request->activities;

            if ($request->hasFile('image')) {
                if ($hotel->image) Storage::disk('public')->delete($hotel->image);
                $data['image'] = $request->file('image')->store('hotels', 'public');
            }

            $hotel->update($data);

            DB::commit();
            return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Hotel $hotel)
    {
        if ($hotel->image) Storage::disk('public')->delete($hotel->image);
        $hotel->delete();
        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully.');
    }
}
