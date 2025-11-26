<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\JoinEvent;
use Carbon\Carbon;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoinEventController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('api')->user();

        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $events = Event::orderBy('id', 'asc')
            ->paginate($perPage, ['*'], 'page', $page);

        $events = $events->map(function ($event) use ($user) {
            if ($event->start_time) {
                $event->start_time = Carbon::parse($event->start_time)->format('h:i A');
            }
            if ($event->end_time) {
                $event->end_time = Carbon::parse($event->end_time)->format('h:i A');
            }


            $event['is_joined'] = $event->joinedUsers()
                ->where('user_id', $user->id)
                ->exists();
            return $event;
        });

        return response()->json([
            'success' => true,
            'message' => 'Events retrieved successfully',
            'data' => $events
        ]);
    }
    public function join(Request $request, $eventId)
{
    $user = auth('api')->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated.'
        ], 401);
    }

    $event = Event::find($eventId);
    if (!$event) {
        return response()->json([
            'success' => false,
            'message' => 'Event not found.'
        ], 404);
    }

    $alreadyJoined = JoinEvent::where('user_id', $user->id)
        ->where('event_id', $eventId)
        ->exists();

    if ($alreadyJoined) {
        return response()->json([
            'success' => false,
            'message' => 'You already joined this event.',
            'join_count' => $event->joins()->count() // count of joins
        ], 409);
    }

    JoinEvent::create([
        'user_id' => $user->id,
        'event_id' => $eventId,
    ]);

    // Return total join count
    $joinCount = $event->joins()->count();

    return response()->json([
        'success' => true,
        'message' => 'You successfully joined the event!',
        'join_count' => $joinCount
    ], 201);
}


    public function date(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $events = Event::where('date', $request->date)->get();

        if ($events->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No events found on this date',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Events retrieved successfully',
            'data' => $events
        ]);
    }
}
