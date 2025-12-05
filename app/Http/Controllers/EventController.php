<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Events;

class EventController extends Controller
{
    public function registerevent(Request $request)
    {


        try {
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
            $event = Events::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'time_zone' => $validated['time_zone'],
                'location' => $validated['location'],
            ]);
            return response()->json(['message' => 'Event registered successfully', 'event' => $event], 201);


        } catch (\Throwable $th) {
            \Log::error('Event registration error: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to register event', 'details' => $th->getMessage()], 500);
        }
    }
}
