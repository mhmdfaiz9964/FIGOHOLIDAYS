<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\OfferType;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Offer::with(['category', 'types']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('category', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $offers = $query->latest()->paginate(10);
        return view('offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = OfferCategory::active()->get();
        $types = OfferType::all();
        return view('offers.create', compact('categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'offer_category_id' => 'required|exists:offer_categories,id',
            'offer_type_id' => 'required|exists:offer_types,id',
            'status' => 'required|in:active,inactive',
            'price' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'thumbnail_image' => 'required|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:10240',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:102400', // 100MB
            'nights' => 'required|integer|min:0',
            'days' => 'required|integer|min:0',
            'star_rating' => 'required|integer|between:1,5',
            'types' => 'required|array',
            'types.*' => 'exists:offer_types,id',
            'sidebar_banner_image' => 'nullable|image|max:5120',
            'itineraries' => 'required|array|min:1',
            'itineraries.*.day' => 'required|string',
            'itineraries.*.title' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['thumbnail_image', 'video', 'sidebar_banner_image', 'gallery_images', 'types', 'itineraries', 'offer_type_id']);
            $data['offer_type_id'] = $request->offer_type_id;

            if ($request->hasFile('thumbnail_image')) {
                $data['thumbnail_image'] = $request->file('thumbnail_image')->store('offers/thumbnails', 'public');
            }

            if ($request->hasFile('video')) {
                $data['video'] = $request->file('video')->store('offers/videos', 'public');
            }

            if ($request->hasFile('sidebar_banner_image')) {
                $data['sidebar_banner_image'] = $request->file('sidebar_banner_image')->store('offers/banners', 'public');
            }

            if ($request->hasFile('gallery_images')) {
                $gallery = [];
                foreach ($request->file('gallery_images') as $file) {
                    $gallery[] = $file->store('offers/gallery', 'public');
                }
                $data['gallery_images'] = $gallery;
            }

            $offer = Offer::create($data);
            $offer->types()->sync($request->types);

            // Itineraries Processing
            foreach ($request->itineraries as $index => $item) {
                $itineraryData = [
                    'day' => $item['day'],
                    'title' => $item['title'],
                    'description' => $item['description'] ?? null,
                ];

                // Multiple Images for Itinerary
                if (isset($request->file('itineraries')[$index]['images'])) {
                    $itImages = [];
                    foreach ($request->file('itineraries')[$index]['images'] as $file) {
                        $itImages[] = $file->store('offers/itinerary', 'public');
                    }
                    $itineraryData['images'] = $itImages;
                }

                // Activities Processing (Text + Icon)
                if (isset($item['activities'])) {
                    $activities = [];
                    foreach ($item['activities'] as $actIndex => $act) {
                        if (empty($act['text'])) continue;
                        
                        $actItem = ['text' => $act['text']];
                        if (isset($request->file('itineraries')[$index]['activities'][$actIndex]['icon'])) {
                            $actItem['icon'] = $request->file('itineraries')[$index]['activities'][$actIndex]['icon']->store('offers/icons', 'public');
                        }
                        $activities[] = $actItem;
                    }
                    $itineraryData['activities'] = $activities;
                }

                $offer->itineraries()->create($itineraryData);
            }

            DB::commit();
            return redirect()->route('offers.index')->with('success', 'Offer and Itinerary created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Critical Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        $offer->load(['category', 'types', 'itineraries']);
        $categories = OfferCategory::active()->get();
        $types = OfferType::all();
        return view('offers.edit', compact('offer', 'categories', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'offer_category_id' => 'required|exists:offer_categories,id',
            'offer_type_id' => 'required|exists:offer_types,id',
            'status' => 'required|in:active,inactive',
            'price' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'thumbnail_image' => 'nullable|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:10240',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:102400',
            'nights' => 'required|integer|min:0',
            'days' => 'required|integer|min:0',
            'star_rating' => 'required|integer|between:1,5',
            'types' => 'required|array',
            'itineraries' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['thumbnail_image', 'video', 'sidebar_banner_image', 'gallery_images', 'types', 'itineraries', '_method', '_token', 'offer_type_id']);
            $data['offer_type_id'] = $request->offer_type_id;

            // Handle Media Updates
            if ($request->hasFile('thumbnail_image')) {
                if ($offer->thumbnail_image) Storage::disk('public')->delete($offer->thumbnail_image);
                $data['thumbnail_image'] = $request->file('thumbnail_image')->store('offers/thumbnails', 'public');
            }

            if ($request->hasFile('video')) {
                if ($offer->video) Storage::disk('public')->delete($offer->video);
                $data['video'] = $request->file('video')->store('offers/videos', 'public');
            }

            if ($request->hasFile('sidebar_banner_image')) {
                if ($offer->sidebar_banner_image) Storage::disk('public')->delete($offer->sidebar_banner_image);
                $data['sidebar_banner_image'] = $request->file('sidebar_banner_image')->store('offers/banners', 'public');
            }

            if ($request->hasFile('gallery_images')) {
                // For gallery, we usually keep old ones or replace all. 
                // Here we replace all for simplicity, or you can add logic to keep specific ones.
                if ($offer->gallery_images) {
                    foreach ($offer->gallery_images as $oldImg) Storage::disk('public')->delete($oldImg);
                }
                $gallery = [];
                foreach ($request->file('gallery_images') as $file) {
                    $gallery[] = $file->store('offers/gallery', 'public');
                }
                $data['gallery_images'] = $gallery;
            }

            $offer->update($data);
            $offer->types()->sync($request->types);

            // Itineraries Update (Delete old and re-create is safest for complex dynamic forms)
            foreach ($offer->itineraries as $it) {
                if ($it->images) foreach ($it->images as $img) Storage::disk('public')->delete($img);
                if ($it->activities) {
                    foreach ($it->activities as $act) {
                        if (isset($act['icon'])) Storage::disk('public')->delete($act['icon']);
                    }
                }
                $it->delete();
            }

            foreach ($request->itineraries as $index => $item) {
                $itineraryData = [
                    'day' => $item['day'],
                    'title' => $item['title'],
                    'description' => $item['description'] ?? null,
                ];

                if (isset($request->file('itineraries')[$index]['images'])) {
                    $itImages = [];
                    foreach ($request->file('itineraries')[$index]['images'] as $file) {
                        $itImages[] = $file->store('offers/itinerary', 'public');
                    }
                    $itineraryData['images'] = $itImages;
                }

                if (isset($item['activities'])) {
                    $activities = [];
                    foreach ($item['activities'] as $actIndex => $act) {
                        if (empty($act['text'])) continue;
                        $actItem = ['text' => $act['text']];
                        if (isset($request->file('itineraries')[$index]['activities'][$actIndex]['icon'])) {
                            $actItem['icon'] = $request->file('itineraries')[$index]['activities'][$actIndex]['icon']->store('offers/icons', 'public');
                        }
                        $activities[] = $actItem;
                    }
                    $itineraryData['activities'] = $activities;
                }

                $offer->itineraries()->create($itineraryData);
            }

            DB::commit();
            return redirect()->route('offers.index')->with('success', 'Offer updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        try {
            DB::beginTransaction();
            
            // Clean up main media
            if ($offer->thumbnail_image) Storage::disk('public')->delete($offer->thumbnail_image);
            if ($offer->video) Storage::disk('public')->delete($offer->video);
            if ($offer->sidebar_banner_image) Storage::disk('public')->delete($offer->sidebar_banner_image);
            if ($offer->gallery_images) {
                foreach ($offer->gallery_images as $img) Storage::disk('public')->delete($img);
            }

            // Clean up itineraries
            foreach ($offer->itineraries as $it) {
                if ($it->images) {
                    foreach ($it->images as $img) Storage::disk('public')->delete($img);
                }
                if ($it->activities) {
                    foreach ($it->activities as $act) {
                        if (isset($act['icon'])) Storage::disk('public')->delete($act['icon']);
                    }
                }
            }

            $offer->delete(); // Cascades to itineraries if FK set correctly, but manual cleanup is done.
            
            DB::commit();
            return redirect()->route('offers.index')->with('success', 'Offer and all associated media deleted.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Deletetion failed: ' . $e->getMessage());
        }
    }
}
