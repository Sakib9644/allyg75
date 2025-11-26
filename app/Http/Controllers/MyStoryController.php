<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyStory;
use App\Models\StoryDescrip;

class MyStoryController extends Controller
{
    // Show list of stories
    public function index()
    {
        $stories = MyStory::latest()->paginate(10);
        return view('backend.layouts.mystories.index', compact('stories'));
    }

    // Show form to create a story
    public function create()
    {
        return view('backend.layouts.mystories.create');
    }

    // Store a new story
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_descriptions' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Upload thumbnail
        $thumbnailPath = Helper::fileUpload(
            $request->file('thumbnail'),
            'story_thumbnails',
            time() . '_' . $request->file('thumbnail')->getClientOriginalName()
        );

        // Create story
        $story = MyStory::create([
            'title' => $validated['title'],
            'short_descriptions' => $validated['short_descriptions'],
            'thumbnail' => $thumbnailPath,
        ]);

        // Upload cover image
        $coverImagePath = Helper::fileUpload(
            $request->file('cover_image'),
            'story_descrip_covers',
            time() . '_' . $request->file('cover_image')->getClientOriginalName()
        );

        // Create story description
        StoryDescrip::create([
            'my_stories_id' => $story->id,
            'description' => $validated['description'],
            'cover_image' => $coverImagePath,
        ]);

        return redirect()->route('admin.mystories.index')
            ->with('t-success', 'Story created successfully.');
    }

    // Show form to edit a story
    public function edit(MyStory $mystory)
    {
        $storyDescription = $mystory->descriptions()->first(); // Assuming one-to-one
        return view('backend.layouts.mystories.edit', compact('mystory', 'storyDescription'));
    }

    // Update an existing story
    public function update(Request $request, MyStory $mystory)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_descriptions' => 'required|string',
            'thumbnail' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
            'description' => 'required|string',
            'cover_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Update thumbnail if uploaded
        if ($request->hasFile('thumbnail')) {
            $mystory->thumbnail = Helper::fileUpload(
                $request->file('thumbnail'),
                'story_thumbnails',
                time() . '_' . $request->file('thumbnail')->getClientOriginalName()
            );
        }

        $mystory->title = $validated['title'];
        $mystory->short_descriptions = $validated['short_descriptions'];
        $mystory->save();

        // Update or create story description
        $storyDescription = $mystory->descriptions()->firstOrNew([]);
        if ($request->hasFile('cover_image')) {
            $storyDescription->cover_image = Helper::fileUpload(
                $request->file('cover_image'),
                'story_descrip_covers',
                time() . '_' . $request->file('cover_image')->getClientOriginalName()
            );
        }
        $storyDescription->description = $validated['description'];
        $storyDescription->my_stories_id = $mystory->id;
        $storyDescription->save();

        return redirect()->route('admin.mystories.index')
            ->with('t-success', 'Story updated successfully.');
    }

    // Delete a story
    public function destroy(MyStory $mystory)
    {
        $mystory->delete();

        return redirect()->route('admin.mystories.index')
            ->with('t-success', 'Story deleted successfully.');
    }
}
