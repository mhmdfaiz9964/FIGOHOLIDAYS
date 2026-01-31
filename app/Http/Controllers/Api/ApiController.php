<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Visa;
use App\Models\HomePageHero;
use App\Models\Partner;
use App\Models\OfferCategory;
use App\Models\Offer;
use App\Models\Hotel;
use App\Models\Destination;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Faq;
use App\Models\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    private function getFullUrl($path)
    {
        if (!$path) return null;
        if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
        return url(Storage::url($path));
    }

    public function settings()
    {
        $settings = GeneralSetting::first();
        if ($settings) {
            $settings->logo = $this->getFullUrl($settings->logo);
            $settings->footer_logo = $this->getFullUrl($settings->footer_logo);
        }
        return response()->json($settings);
    }

    public function visa()
    {
        $visa = Visa::first();
        if ($visa) {
            $visa->background_image = $this->getFullUrl($visa->background_image);
            $visa->image = $this->getFullUrl($visa->image);
        }
        return response()->json($visa);
    }

    public function heroes()
    {
        $hero = HomePageHero::first();
        if (!$hero) return response()->json(null);

        return response()->json([
            'tag' => $hero->tag,
            'tag_size' => str_replace('px', '', $hero->tag_size),
            'title' => $hero->title,
            'title_size' => str_replace('px', '', $hero->title_size),
            'highlighted_title' => $hero->highlighted_title,
            'highlight_size' => str_replace('px', '', $hero->highlight_size),
            'description' => $hero->description,
            'description_size' => str_replace('px', '', $hero->description_size),
            'background_image' => $this->getFullUrl($hero->background_image),
            'background_images' => array_map(function($path) {
                return $this->getFullUrl($path);
            }, $hero->background_images ?? []),
            'btn1_text' => $hero->btn1_text,
            'btn1_url' => $hero->btn1_url,
            'btn1_icon' => $this->getFullUrl($hero->btn1_icon),
            'btn2_text' => $hero->btn2_text,
            'btn2_url' => $hero->btn2_url,
            'btn2_icon' => $this->getFullUrl($hero->btn2_icon),
        ]);
    }

    public function partners()
    {
        $partners = Partner::all()->map(function($partner) {
            return [
                'name' => $partner->name,
                'image' => $this->getFullUrl($partner->image),
            ];
        });
        return response()->json($partners);
    }

    public function categories()
    {
        $categories = OfferCategory::all()->map(function($cat) {
            return [
                'id' => $cat->id,
                'title' => $cat->title,
                'description' => $cat->sub_heading,
                'image' => $this->getFullUrl($cat->banner_image),
            ];
        });
        return response()->json($categories);
    }

    public function offers()
    {
        $offers = Offer::with(['category', 'types', 'itineraries'])->latest()->get()->map(function($offer) {
            return $this->formatOffer($offer);
        });
        return response()->json($offers);
    }

    public function offerShow($id)
    {
        $offer = Offer::with(['category', 'types', 'itineraries'])->findOrFail($id);
        return response()->json($this->formatOffer($offer));
    }

    private function formatOffer($offer)
    {
        $offer->thumbnail_image = $this->getFullUrl($offer->thumbnail_image);
        $offer->sidebar_banner_image = $this->getFullUrl($offer->sidebar_banner_image);
        
        if (is_array($offer->gallery_images)) {
            $offer->gallery_images = array_map(function($img) {
                return $this->getFullUrl($img);
            }, $offer->gallery_images);
        }

        if ($offer->itineraries) {
            $offer->itineraries->transform(function($itinerary) {
                if (is_array($itinerary->images)) {
                    $itinerary->images = array_map(function($img) {
                        return $this->getFullUrl($img);
                    }, $itinerary->images);
                }
                return $itinerary;
            });
        }
        
        return $offer;
    }

    public function hotels()
    {
        $hotels = Hotel::with('hotelType')->latest()->get()->map(function($hotel) {
            return [
                'id' => $hotel->id,
                'name' => $hotel->name,
                'description' => $hotel->meta_description,
                'image' => $this->getFullUrl($hotel->image),
                'location' => $hotel->location,
                'category' => $hotel->hotel_type_id, // Keep ID for matching if needed
                'hotel_type' => [
                    'title' => $hotel->hotelType ? $hotel->hotelType->name : 'فنادق 5 نجوم'
                ],
                'stars' => (int)$hotel->rating,
                'pricePerNight' => (float)$hotel->price_per_night,
                'currency' => '$',
                'amenities' => $hotel->activities ?: [],
            ];
        });
        return response()->json($hotels);
    }

    public function hotelShow($id)
    {
        $hotel = Hotel::with('hotelType')->findOrFail($id);
        $hotel->image = $this->getFullUrl($hotel->image);
        return response()->json($hotel);
    }

    public function destinations(Request $request)
    {
        $query = Destination::with('province');
        
        // Filter by province_id if provided
        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }
        
        $destinations = $query->latest()->get()->map(function($dest) {
            $dest->image = $this->getFullUrl($dest->image);
            if (is_array($dest->attractions)) {
                $dest->attractions = array_map(function($attr) {
                    if (is_array($attr) && isset($attr['image'])) {
                        $attr['image'] = $this->getFullUrl($attr['image']);
                    }
                    return $attr;
                }, $dest->attractions);
            }
            return $dest;
        });
        return response()->json($destinations);
    }

    public function destinationShow($id)
    {
        $dest = Destination::with('province')->findOrFail($id);
        $dest->image = $this->getFullUrl($dest->image);
        if (is_array($dest->attractions)) {
            $dest->attractions = array_map(function($attr) {
                if (is_array($attr) && isset($attr['image'])) {
                    $attr['image'] = $this->getFullUrl($attr['image']);
                }
                return $attr;
            }, $dest->attractions);
        }
        return response()->json($dest);
    }

    public function restaurants(Request $request)
    {
        $query = Restaurant::query();
        
        // Filter by type (cuisine type) if provided
        if ($request->filled('type')) {
            $query->where('type', 'like', '%' . $request->type . '%');
        }
        
        $restaurants = $query->latest()->get()->map(function($res) {
            $res->image = $this->getFullUrl($res->image);
            return $res;
        });
        return response()->json($restaurants);
    }

    public function reviews()
    {
        $reviews = Review::latest()->get()->map(function($rev) {
            return [
                'id' => $rev->id,
                'author' => $rev->user_name,
                'user_image' => $this->getFullUrl($rev->user_image),
                'location' => $rev->user_location,
                'rating' => (int)$rev->rating,
                'comment' => $rev->description,
                'source' => $rev->source ?: 'TripAdvisor',
                'date' => $rev->date ? $rev->date->format('F Y') : null,
            ];
        });
        return response()->json($reviews);
    }

    public function faqs()
    {
        return response()->json(Faq::latest()->get());
    }

    public function transportations()
    {
        $trans = Transportation::latest()->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->title,
                'type' => $item->vehicle_type,
                'image' => $this->getFullUrl($item->vehicle_image),
                'pricePerDay' => $item->starting_price,
                'seats' => $item->seats ?? 4, // Default if not in DB
                'bags' => $item->bags ?? 2,   // Default if not in DB
                'includes' => $item->includes,
            ];
        });
        return response()->json($trans);
    }

    public function transportationPage()
    {
        $page = \App\Models\TransportationPage::first();
        if ($page) {
            $page->image_01 = $this->getFullUrl($page->image_01);
            $page->image_02 = $this->getFullUrl($page->image_02);
        }
        return response()->json($page);
    }
}
