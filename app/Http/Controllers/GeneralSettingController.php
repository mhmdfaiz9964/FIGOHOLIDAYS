<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $settings = GeneralSetting::first() ?: new GeneralSetting();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = GeneralSetting::first() ?: new GeneralSetting();

        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'footer_logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
            'emails' => 'nullable|array',
            'whatsapps' => 'nullable|array',
            'landlines' => 'nullable|array',
            'head_offices' => 'nullable|array',
            'map_urls' => 'nullable|array',
            'experience_count' => 'nullable|integer',
            'destination_count' => 'nullable|integer',
            'customers_count' => 'nullable|integer',
            'trip_count' => 'nullable|integer',
            'primary_color' => 'nullable|string|max:7',
        ]);

        $data = $request->except(['logo', 'footer_logo', 'favicon']);

        // Filter out empty values from arrays
        $data['emails'] = array_values(array_filter($request->input('emails', [])));
        $data['whatsapps'] = array_values(array_filter($request->input('whatsapps', [])));
        $data['landlines'] = array_values(array_filter($request->input('landlines', [])));
        $data['head_offices'] = array_values(array_filter($request->input('head_offices', [])));
        $data['map_urls'] = array_values(array_filter($request->input('map_urls', [])));

        if ($request->hasFile('logo')) {
            if ($settings->logo)
                Storage::disk('public')->delete($settings->logo);
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('footer_logo')) {
            if ($settings->footer_logo)
                Storage::disk('public')->delete($settings->footer_logo);
            $data['footer_logo'] = $request->file('footer_logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon)
                Storage::disk('public')->delete($settings->favicon);
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        if ($settings->exists) {
            $settings->update($data);
        } else {
            GeneralSetting::create($data);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
