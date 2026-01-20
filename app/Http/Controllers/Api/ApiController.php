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
        $heroes = HomePageHero::all()->map(function($hero) {
            $hero->image = $this->getFullUrl($hero->image);
            return $hero;
        });
        return response()->json($heroes);
    }

    public function partners()
    {
        $partners = Partner::all()->map(function($partner) {
            $partner->image = $this->getFullUrl($partner->image);
            return $partner;
        });
        return response()->json($partners);
    }

    public function categories()
    {
        $categories = OfferCategory::all()->map(function($cat) {
            $cat->image = $this->getFullUrl($cat->image);
            return $cat;
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
        
        return $offer;
    }

    public function hotels()
    {
        $hotels = Hotel::with('hotelType')->latest()->get()->map(function($hotel) {
            $hotel->image = $this->getFullUrl($hotel->image);
            return $hotel;
        });
        return response()->json($hotels);
    }

    public function hotelShow($id)
    {
        $hotel = Hotel::with('hotelType')->findOrFail($id);
        $hotel->image = $this->getFullUrl($hotel->image);
        return response()->json($hotel);
    }

    public function destinations()
    {
        $destinations = Destination::with('province')->latest()->get()->map(function($dest) {
            $dest->image = $this->getFullUrl($dest->image);
            return $dest;
        });
        return response()->json($destinations);
    }

    public function destinationShow($id)
    {
        $dest = Destination::with('province')->findOrFail($id);
        $dest->image = $this->getFullUrl($dest->image);
        return response()->json($dest);
    }

    public function restaurants()
    {
        $restaurants = Restaurant::latest()->get()->map(function($res) {
            $res->image = $this->getFullUrl($res->image);
            return $res;
        });
        return response()->json($restaurants);
    }

    public function reviews()
    {
        $reviews = Review::latest()->get()->map(function($rev) {
            $rev->user_image = $this->getFullUrl($rev->user_image);
            return $rev;
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
            $item->image = $this->getFullUrl($item->image);
            return $item;
        });
        return response()->json($trans);
    }
}
