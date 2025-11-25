<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of events
     */
    public function index()
    {
        $events = Event::orderBy('date', 'desc')->paginate(10);
        return view('backend.layouts.event.index', compact('events'));
    }


    /**
     * Show the form for creating a new event
     */
    public function create()
    {
        return view('backend.layouts.event.create');
    }

    /**
     * Store a newly created event
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title'      => 'required|string|max:255',
                'date'       => 'required|date',
                'start_time' => 'required',
                'end_time'   => 'required|after_or_equal:start_time',
                'address'    => 'nullable|string',
            ],
        );

        $event = new Event();
        $event->title      = $request->title;
        $event->date       = $request->date;
        $event->start_time = $request->start_time;
        $event->end_time   = $request->end_time;
        $event->address    = $request->address;
        $event->save();

        return redirect()->route('admin.event.index')->with('t-success', 'Event created successfully!');
    }

    /**
     * Show the form for editing an event
     */
    public function edit(Event $event)
    {
        return view('backend.layouts.event.edit', compact('event'));
    }

    /**
     * Update an event
     */
    public function update(Request $request, Event $event)
    {
        $request->validate(
            [
                'title'      => 'required|string|max:255',
                'date'       => 'required|date',
                'start_time' => 'required',
                'end_time'   => 'required|after_or_equal:start_time',
                'address'    => 'nullable|string',
            ]
        );

        $event->title      = $request->title;
        $event->date       = $request->date;
        $event->start_time = $request->start_time;
        $event->end_time   = $request->end_time;
        $event->address    = $request->address;
        $event->save();

        return redirect()->route('admin.event.index')->with('t-success', 'Event updated successfully!');
    }

    /**
     * Remove an event
     */
    public function destroy(Event $event)
    {
        $event->delete();


       $events =  Event::paginate(10);


        return view('helper',compact('events'));
    }
}
