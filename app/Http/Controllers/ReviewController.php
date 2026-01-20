<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Review::query();

        if ($request->filled('search')) {
            $query->where('user_name', 'like', '%' . $request->search . '%')
                  ->orWhere('source', 'like', '%' . $request->search . '%');
        }

        $reviews = $query->latest()->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_image' => 'nullable|image|max:2048',
            'rating' => 'required|integer|between:1,5',
            'description' => 'required|string',
            'date' => 'required|date',
            'source' => 'required|in:Tripadvisor,Google,Facebook,Instagram,Website,Others',
            'added_by' => 'nullable|string|max:255',
            'user_location' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:5120',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['user_image', 'images']);
            
            if ($request->hasFile('user_image')) {
                $data['user_image'] = $request->file('user_image')->store('reviews/users', 'public');
            }

            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $images[] = $image->store('reviews/gallery', 'public');
                }
                $data['images'] = $images;
            }

            Review::create($data);

            DB::commit();
            return redirect()->route('reviews.index')->with('success', 'Review added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_image' => 'nullable|image|max:2048',
            'rating' => 'required|integer|between:1,5',
            'description' => 'required|string',
            'date' => 'required|date',
            'source' => 'required|in:Tripadvisor,Google,Facebook,Instagram,Website,Others',
            'added_by' => 'nullable|string|max:255',
            'user_location' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:5120',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['user_image', 'images', '_method', '_token']);

            if ($request->hasFile('user_image')) {
                if ($review->user_image) Storage::disk('public')->delete($review->user_image);
                $data['user_image'] = $request->file('user_image')->store('reviews/users', 'public');
            }

            if ($request->hasFile('images')) {
                // If appending is preferred, logic would change. Here replacing.
                if ($review->images) {
                    foreach ($review->images as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                $images = [];
                foreach ($request->file('images') as $image) {
                    $images[] = $image->store('reviews/gallery', 'public');
                }
                $data['images'] = $images;
            }

            $review->update($data);

            DB::commit();
            return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Update Failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        if ($review->user_image) Storage::disk('public')->delete($review->user_image);
        if ($review->images) {
            foreach ($review->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Review deleted.');
    }
}
