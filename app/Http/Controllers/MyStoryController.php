<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyStory;

class MyStoryController extends Controller
{
    // Show list of stories
    public function index()
    {
        $stories = MyStory::latest()->paginate(10); // paginate 10 per page
        return view('backend.layouts.mystories.index', compact('stories'));
    }

    // Show form to create a new story
    public function create()
    {
        return view('backend.layouts.mystories.create');
    }

    // Store new story
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_descriptions' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Upload thumbnail using Helper
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = Helper::fileUpload(
                $request->file('thumbnail'),
                'story_thumbnails', // folder name
                time() . '_' . $request->file('thumbnail')->getClientOriginalName()
            );
        }

        MyStory::create([
            'title' => $validated['title'],
            'short_descriptions' => $validated['short_descriptions'],
            'thumbnail' => $thumbnailPath ?? null,
        ]);

        return redirect()->route('admin.mystories.index')
            ->with('t-success', 'Story created successfully.');
    }

    // Show form to edit a story
    public function edit(MyStory $mystory)
    {
        return view('backend.layouts.mystories.edit', compact('mystory'));
    }

    // Update story
    public function update(Request $request, MyStory $mystory)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_descriptions' => 'required|string',
            'thumbnail' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = Helper::fileUpload(
                $request->file('thumbnail'),
                'story_thumbnails',
                time() . '_' . $request->file('thumbnail')->getClientOriginalName()
            );
            $mystory->thumbnail = $thumbnailPath;
        }

        $mystory->title = $validated['title'];
        $mystory->short_descriptions = $validated['short_descriptions'];
        $mystory->save();

        return redirect()->route('admin.mystories.index')
            ->with('t-success', 'Story updated successfully.');
    }


    // Delete story
    public function destroy(MyStory $mystory)
    {
        $mystory->delete();

        return redirect()->route('admin.mystories.index')
            ->with('t-success', 'Story deleted successfully.');
    }
}
