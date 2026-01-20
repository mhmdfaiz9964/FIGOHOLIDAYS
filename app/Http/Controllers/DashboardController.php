<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Hotel;
use App\Models\Destination;
use App\Models\Review;
use App\Models\Partner;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'offers' => Offer::count(),
            'hotels' => Hotel::count(),
            'destinations' => Destination::count(),
            'reviews' => Review::count(),
            'partners' => Partner::count(),
            'restaurants' => Restaurant::count(),
        ];

        $recentOffers = Offer::with('category')->latest()->take(5)->get();
        $recentReviews = Review::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentOffers', 'recentReviews'));
    }
}
