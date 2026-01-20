<?php

namespace App\Http\Controllers;

use App\Models\HomePageHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    /**
     * Display the single hero management page.
     */
    public function index()
    {
        $hero = HomePageHero::first() ?: new HomePageHero();
        return view('heroes.manage', compact('hero'));
    }

    /**
     * Store or update the single hero section.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tag' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'highlighted_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'background_image' => 'nullable|image|max:10240', // 10MB
            'btn1_text' => 'nullable|string|max:255',
            'btn1_url' => 'nullable|string|max:255',
            'btn1_icon' => 'nullable|image|max:2048',
            'btn2_text' => 'nullable|string|max:255',
            'btn2_url' => 'nullable|string|max:255',
            'btn2_icon' => 'nullable|image|max:2048',
        ]);

        $hero = HomePageHero::first() ?: new HomePageHero();
        $data = $request->except(['background_image', 'btn1_icon', 'btn2_icon']);

        if ($request->hasFile('background_image')) {
            if ($hero->background_image) Storage::disk('public')->delete($hero->background_image);
            $data['background_image'] = $request->file('background_image')->store('heroes/backgrounds', 'public');
        }

        if ($request->hasFile('btn1_icon')) {
            if ($hero->btn1_icon) Storage::disk('public')->delete($hero->btn1_icon);
            $data['btn1_icon'] = $request->file('btn1_icon')->store('heroes/icons', 'public');
        }

        if ($request->hasFile('btn2_icon')) {
            if ($hero->btn2_icon) Storage::disk('public')->delete($hero->btn2_icon);
            $data['btn2_icon'] = $request->file('btn2_icon')->store('heroes/icons', 'public');
        }

        if ($hero->exists) {
            $hero->update($data);
        } else {
            HomePageHero::create($data);
        }

        return redirect()->route('heroes.index')->with('success', 'Home page banner updated successfully.');
    }
}
