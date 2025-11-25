<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoryDescrip;
use App\Models\MyStory;
use App\Helpers\Helper;

class StoryDescripController extends Controller
{
    /**
     * Show form to create a new description for a story
     */
    public function create(MyStory $story)
    {
        return view('backend.layouts.story_descrips.create', compact('story'));
    }
    

    /**
     * Store a new description
     */
    public function store(Request $request)
    {
        $request->validate([
            'my_stories_id' => 'required|exists:my_stories,id',
            'description' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $coverImagePath = Helper::fileUpload(
            $request->file('cover_image'),
            'story_descrip_covers',
            time() . '_' . $request->file('cover_image')->getClientOriginalName()
        );

        StoryDescrip::create([
            'my_stories_id' => $request->my_stories_id,
            'description' => $request->description,
            'cover_image' => $coverImagePath,
        ]);

        return redirect()->route('admin.mystories.index')
            ->with('t-success', 'Description added successfully.');
    }
    public function destroy(StoryDescrip $description)
    {
        if ($description->cover_image && file_exists(public_path($description->cover_image))) {
            @unlink(public_path($description->cover_image));
        }

        $description->delete();

        return redirect()->route('admin.story_descrips.index', $description->my_stories_id)
            ->with('t-success', 'Description deleted successfully.');
    }
    /**
     * List all descriptions for a story
     */
    public function index(MyStory $story)
    {
        $descriptions = $story->story()->paginate(10); // use the relationship
        return view('backend.layouts.story_descrips.index', compact('story', 'descriptions'));
    }

    /**
     * Show form to edit a description
     */
    public function edit(StoryDescrip $description)
    {
        $story = $description->story; // get the parent story
        return view('backend.layouts.story_descrips.edit', compact('story', 'description'));
    }

    /**
     * Update an existing description
     */
    public function update(Request $request, StoryDescrip $description)
    {
        $request->validate([
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('cover_image')) {
            $coverImagePath = Helper::fileUpload(
                $request->file('cover_image'),
                'story_descrip_covers',
                time() . '_' . $request->file('cover_image')->getClientOriginalName()
            );
            $description->cover_image = $coverImagePath;
        }

        $description->description = $request->description;
        $description->save();

        return redirect()->route('admin.story_descrips.index', $description->my_stories_id)
            ->with('t-success', 'Description updated successfully.');
    }
}
