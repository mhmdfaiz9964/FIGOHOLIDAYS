<?php

namespace App\Http\Controllers;

use App\Models\OfferCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfferCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OfferCategory::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $categories = $query->latest()->paginate(10);
        return view('offer-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = \App\Models\OfferType::all();
        return view('offer-categories.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'banner_image' => 'nullable|image|max:5120', // 5MB
            'slug' => 'nullable|string|max:255|unique:offer_categories,slug',
        ]);

        $data = $request->except('banner_image');
        $data['slug'] = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('categories', 'public');
        }

        $category = OfferCategory::create($data);

        if ($request->has('types')) {
            $category->types()->sync($request->types);
        }

        return redirect()->route('offer-categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfferCategory $offerCategory)
    {
        $types = \App\Models\OfferType::all();
        return view('offer-categories.edit', [
            'category' => $offerCategory,
            'types' => $types
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfferCategory $offerCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'banner_image' => 'nullable|image|max:5120',
            'slug' => 'required|string|max:255|unique:offer_categories,slug,' . $offerCategory->id,
        ]);

        $data = $request->except('banner_image');
        $data['slug'] = Str::slug($request->slug);

        if ($request->hasFile('banner_image')) {
            if ($offerCategory->banner_image) {
                Storage::disk('public')->delete($offerCategory->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('categories', 'public');
        }

        $offerCategory->update($data);

        if ($request->has('types')) {
            $offerCategory->types()->sync($request->types);
        } else {
            $offerCategory->types()->detach();
        }

        return redirect()->route('offer-categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfferCategory $offerCategory)
    {
        if ($offerCategory->banner_image) {
            Storage::disk('public')->delete($offerCategory->banner_image);
        }

        $offerCategory->delete();

        return redirect()->route('offer-categories.index')->with('success', 'Category deleted successfully.');
    }
    /**
     * Check if name or slug is unique (AJAX).
     */
    public function checkUniqueness(Request $request)
    {
        $field = $request->field;
        $value = $field === 'slug' ? Str::slug($request->value) : $request->value;
        $id = $request->id;

        $exists = OfferCategory::where($field, $value)
            ->when($id, function ($q) use ($id) {
                return $q->where('id', '!=', $id);
            })
            ->exists();

        return response()->json(['unique' => !$exists]);
    }
}
