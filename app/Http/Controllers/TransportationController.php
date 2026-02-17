<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TransportationController extends Controller
{
    public function index(Request $request)
    {
        $query = Transportation::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('vehicle_type', 'like', '%' . $request->search . '%');
        }
        $transportations = $query->latest()->paginate(10);
        return view('transportations.index', compact('transportations'));
    }

    public function create()
    {
        return view('transportations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'vehicle_image' => 'nullable|image|max:5120',
            'label_icon' => 'nullable|image|max:2048',
            'starting_price' => 'required|numeric|min:0',
            'seats' => 'required|integer|min:1',
            'bags' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'includes' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['vehicle_image', 'label_icon', 'includes']);

            if ($request->hasFile('vehicle_image')) {
                $data['vehicle_image'] = $request->file('vehicle_image')->store('transportation/vehicles', 'public');
            }

            if ($request->hasFile('label_icon')) {
                $data['label_icon'] = $request->file('label_icon')->store('transportation/icons', 'public');
            }

            // Handle Includes (Icon + Text)
            if ($request->has('includes')) {
                $includes = [];
                foreach ($request->input('includes') as $index => $item) {
                    if (empty($item['title']))
                        continue;

                    $includeItem = ['title' => $item['title']];

                    if (isset($request->file('includes')[$index]['icon'])) {
                        $includeItem['icon'] = $request->file('includes')[$index]['icon']->store('transportation/includes', 'public');
                    }

                    $includes[] = $includeItem;
                }
                $data['includes'] = $includes;
            }

            Transportation::create($data);

            DB::commit();
            return redirect()->route('transportations.index')->with('success', 'Transportation added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Transportation $transportation)
    {
        return view('transportations.edit', compact('transportation'));
    }

    public function update(Request $request, Transportation $transportation)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'vehicle_image' => 'nullable|image|max:5120',
            'label_icon' => 'nullable|image|max:2048',
            'starting_price' => 'required|numeric|min:0',
            'seats' => 'required|integer|min:1',
            'bags' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['vehicle_image', 'label_icon', 'includes', '_method', '_token']);

            if ($request->hasFile('vehicle_image')) {
                if ($transportation->vehicle_image)
                    Storage::disk('public')->delete($transportation->vehicle_image);
                $data['vehicle_image'] = $request->file('vehicle_image')->store('transportation/vehicles', 'public');
            }

            if ($request->hasFile('label_icon')) {
                if ($transportation->label_icon)
                    Storage::disk('public')->delete($transportation->label_icon);
                $data['label_icon'] = $request->file('label_icon')->store('transportation/icons', 'public');
            }

            // Handle Includes Logic (Simpler to replace)
            if ($request->has('includes')) {
                $includes = [];
                $oldIncludes = $transportation->includes ?? [];

                foreach ($request->input('includes') as $index => $item) {
                    if (empty($item['title']))
                        continue;

                    $includeItem = ['title' => $item['title']];

                    // If new file uploaded
                    if (isset($request->file('includes')[$index]['icon'])) {
                        $includeItem['icon'] = $request->file('includes')[$index]['icon']->store('transportation/includes', 'public');
                    }
                    // Keep old icon if it exists and no new file
                    elseif (isset($item['old_icon'])) {
                        $includeItem['icon'] = $item['old_icon'];
                    }

                    $includes[] = $includeItem;
                }
                $data['includes'] = $includes;

                // Cleanup old images that aren't in the new list
                foreach ($oldIncludes as $old) {
                    $stillExists = false;
                    foreach ($includes as $curr) {
                        if (isset($curr['icon']) && $curr['icon'] == $old['icon'])
                            $stillExists = true;
                    }
                    if (!$stillExists && isset($old['icon']))
                        Storage::disk('public')->delete($old['icon']);
                }
            }

            $transportation->update($data);

            DB::commit();
            return redirect()->route('transportations.index')->with('success', 'Transportation updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Update Failed: ' . $e->getMessage());
        }
    }

    public function destroy(Transportation $transportation)
    {
        if ($transportation->vehicle_image)
            Storage::disk('public')->delete($transportation->vehicle_image);
        if ($transportation->label_icon)
            Storage::disk('public')->delete($transportation->label_icon);
        if ($transportation->includes) {
            foreach ($transportation->includes as $inc) {
                if (isset($inc['icon']))
                    Storage::disk('public')->delete($inc['icon']);
            }
        }
        $transportation->delete();
        return redirect()->route('transportations.index')->with('success', 'Transportation deleted.');
    }
}
