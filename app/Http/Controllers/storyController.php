<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyStory;
use App\Models\StoryDescrip;

class storyController extends Controller
{
    // List all stories
    public function index()
    {
        $stories = MyStory::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Stories retrieved successfully',
            'data' => $stories
        ]);
    }

    // Get all descriptions for a specific story by ID
    public function details($id)
    {
        $story = MyStory::find($id);

        if (!$story) {
            return response()->json([
                'success' => false,
                'message' => 'Story not found',
                'data' => null
            ], 404);
        }

        $descriptions = StoryDescrip::where('my_stories_id', $id)->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Descriptions retrieved successfully',
            'data' => $descriptions

        ]);
    }
}
