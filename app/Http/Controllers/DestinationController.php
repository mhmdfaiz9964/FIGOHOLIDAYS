<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::with('province');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $destinations = $query->latest()->paginate(10);
        return view('destinations.index', compact('destinations'));
    }

    public function create()
    {
        $provinces = Province::all();
        return view('destinations.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:5120',
            'province_id' => 'required|exists:provinces,id',
            'attractions' => 'nullable|array',
            'description' => 'nullable|string',
            'label' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except('image');

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('destinations', 'public');
            }

            Destination::create($data);

            DB::commit();
            return redirect()->route('destinations.index')->with('success', 'Destination created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Destination $destination)
    {
        $provinces = Province::all();
        return view('destinations.edit', compact('destination', 'provinces'));
    }

    public function update(Request $request, Destination $destination)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:5120',
            'province_id' => 'required|exists:provinces,id',
            'attractions' => 'nullable|array',
            'description' => 'nullable|string',
            'label' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['image', '_method', '_token']);

            if ($request->hasFile('image')) {
                if ($destination->image) Storage::disk('public')->delete($destination->image);
                $data['image'] = $request->file('image')->store('destinations', 'public');
            }

            $destination->update($data);

            DB::commit();
            return redirect()->route('destinations.index')->with('success', 'Destination updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Update Failed: ' . $e->getMessage());
        }
    }

    public function destroy(Destination $destination)
    {
        if ($destination->image) Storage::disk('public')->delete($destination->image);
        $destination->delete();
        return redirect()->route('destinations.index')->with('success', 'Destination deleted.');
    }
}
