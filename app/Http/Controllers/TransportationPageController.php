<?php

namespace App\Http\Controllers;

use App\Models\TransportationPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransportationPageController extends Controller
{
    public function edit()
    {
        $page = TransportationPage::firstOrCreate([], [
            'main_title' => 'Car Rental with Driver',
            'main_subtitle' => 'Starting from $60 in Sri Lanka',
            'faqs' => []
        ]);
        return view('transportations.page_edit', compact('page'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'main_title' => 'required|string|max:255',
            'main_subtitle' => 'required|string|max:255',
            'image_01' => 'nullable|image|max:5120',
            'image_02' => 'nullable|image|max:5120',
            'faqs' => 'nullable|array',
        ]);

        $page = TransportationPage::first();
        $data = $request->except(['image_01', 'image_02']);

        if ($request->hasFile('image_01')) {
            if ($page->image_01) Storage::disk('public')->delete($page->image_01);
            $data['image_01'] = $request->file('image_01')->store('transportation', 'public');
        }

        if ($request->hasFile('image_02')) {
            if ($page->image_02) Storage::disk('public')->delete($page->image_02);
            $data['image_02'] = $request->file('image_02')->store('transportation', 'public');
        }

        $page->update($data);

        return back()->with('success', 'Transportation page updated successfully.');
    }
}
