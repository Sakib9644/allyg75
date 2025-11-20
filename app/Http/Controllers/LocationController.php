<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Center;
use App\Models\Location;

class LocationController extends Controller
{
    // Show list of centers
    public function index()
    {
        $location = Location::latest()->paginate(10); // paginate 10 per page
        return view('backend.layouts.locations.index', compact('location'));
    }

    // Show form to create a new center
    public function create()
    {
        return view('backend.layouts.locations.create');
    }

    // Store new center
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_open' => 'nullable|boolean',
        ]);
        Location::create($validated);

        return redirect()->route('admin.locations.index')
            ->with('t-success', 'Location created successfully.');
    }

    // Show form to edit a center
    public function edit(Location $location)
    {
        return view('backend.layouts.locations.edit', compact('location'));
    }

    // Update center
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_open' => 'nullable|boolean',
            'distance' => 'nullable|numeric',
        ]);

        $location->update($validated);

        return redirect()->route('admin.locations.index')
            ->with('t-success', 'Location updated successfully.');
    }

    // Delete center
    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('t-success', 'Location deleted successfully.');
    }
}
