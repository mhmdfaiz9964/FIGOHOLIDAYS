<?php

namespace App\Http\Controllers;

use App\Models\HomePageHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
            'background_image' => 'nullable|image|max:10240', // Poster image
            'background_images' => 'nullable|array', // Dynamic multi-bg
            'background_images.*' => 'nullable|image|max:10240',
            'tag_size' => 'nullable|string',
            'title_size' => 'nullable|string',
            'highlight_size' => 'nullable|string',
            'description_size' => 'nullable|string',
            'btn1_text' => 'nullable|string|max:255',
            'btn1_url' => 'nullable|string|max:255',
            'btn1_icon' => 'nullable|image|max:2048',
            'btn2_text' => 'nullable|string|max:255',
            'btn2_url' => 'nullable|string|max:255',
            'btn2_icon' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $hero = HomePageHero::first() ?: new HomePageHero();
            $data = $request->except(['background_image', 'background_images', 'btn1_icon', 'btn2_icon', 'existing_bg_images']);

            // Handle Poster Background
            if ($request->hasFile('background_image')) {
                if ($hero->background_image) Storage::disk('public')->delete($hero->background_image);
                $data['background_image'] = $request->file('background_image')->store('heroes/backgrounds', 'public');
            }

            // Handle Multiple Background Images
            $bgImages = $request->input('existing_bg_images', []);
            if ($request->hasFile('background_images')) {
                foreach ($request->file('background_images') as $file) {
                    $bgImages[] = $file->store('heroes/slider', 'public');
                }
            }
            $data['background_images'] = array_values(array_filter($bgImages));

            // Icons
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

            DB::commit();
            return redirect()->route('heroes.index')->with('success', 'Home page banner updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
}
