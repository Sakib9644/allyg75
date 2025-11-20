<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\JoinEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoinEventController extends Controller
{
    // List all events
    public function index()
    {
        $events = Event::orderBy('date', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Events retrieved successfully',
            'data' => $events
        ]);
    }


    // Join an event
    public function join(Request $request, $eventId)
{
    $user = auth('api')->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated.'
        ], 401);
    }

    // Check if the event exists
    $event = Event::find($eventId);
    if (!$event) {
        return response()->json([
            'success' => false,
            'message' => 'Event not found.'
        ], 404);
    }

    // Check if user already joined
    $alreadyJoined = JoinEvent::where('user_id', $user->id)
        ->where('event_id', $eventId)
        ->exists();

    if ($alreadyJoined) {
        return response()->json([
            'success' => false,
            'message' => 'You already joined this event.'
        ], 409); // 409 Conflict is better for duplicate join
    }

    // Create JoinEvent
    JoinEvent::create([
        'user_id' => $user->id,
        'event_id' => $eventId,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'You successfully joined the event!'
    ], 201); // 201 Created
}

}
