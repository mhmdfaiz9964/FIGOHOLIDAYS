<?php

namespace App\Http\Controllers;

use App\Models\Visa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisaController extends Controller
{
    public function index()
    {
        $visa = Visa::first() ?: Visa::create([
            'title' => 'Sri Lanka Electronic Visa (ETA)',
            'update_title' => '2026 updates for Gulf citizens',
            'description' => '<p>Citizens of Saudi Arabia, the UAE, Kuwait, Qatar, Oman, and Bahrain enjoy exceptional facilities...</p>'
        ]);
        return view('visas.edit', compact('visa'));
    }

    public function update(Request $request)
    {
        $visa = Visa::first();

        $request->validate([
            'title' => 'required|string|max:255',
            'background_image' => 'nullable|image|max:5120',
            'image' => 'nullable|image|max:5120',
            'update_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'website_url' => 'nullable|url',
        ]);

        $data = $request->except(['background_image', 'image']);

        if ($request->hasFile('background_image')) {
            if ($visa->background_image) Storage::disk('public')->delete($visa->background_image);
            $data['background_image'] = $request->file('background_image')->store('visas', 'public');
        }

        if ($request->hasFile('image')) {
            if ($visa->image) Storage::disk('public')->delete($visa->image);
            $data['image'] = $request->file('image')->store('visas', 'public');
        }

        $visa->update($data);

        return back()->with('success', 'Visa page updated successfully.');
    }
}
