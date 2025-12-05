<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Events;

class EventController extends Controller
{
    public function registerevent(Request $request)
    {
        $validated= $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'time_zone' => 'required|string|max:100',
            'location' => 'required|string|max:255',
        ]);

        if(!$validated){
            return response()->json(['error' => $validated], 400);
        }

        try {
            $event = Events::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'time_zone' => $request->time_zone,
                'location' => $request->location,
            ]);
            return response()->json(['message' => 'Event registered successfully', 'event' => $event], 201);


        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to register event', 'details' => $th->getMessage()], 500);
        }
    }
}
