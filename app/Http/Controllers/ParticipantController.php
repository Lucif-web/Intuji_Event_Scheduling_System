<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participants;

class ParticipantController extends Controller
{
    public function registerparticipent(Request $request)
    {

        try {
            $validated= $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'rsvp_status' => 'required|string|in:accepted,declined,pending',
            ]);
            if(!$validated){
                return response()->json(['error' => $validated], 400);
            }
            $search = Participants::where('email', $request->email)->where('event_id', $request->event_id)->first();
            if($search){
                return response()->json(['error' => 'Participant with this email is already registered for the event'], 409);
            }

            $searchemail = Participants::where('email', $request->email)->first();
            if($searchemail && $searchemail->event->end_time > $request->event()->start_time){
            return response()->json(['error' => 'Participant has a scheduling conflict with another event'], 409);
        }
            $participant = Participants::create([
                'event_id' => $validated['event_id'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'rsvp_status' => $validated['rsvp_status'],
            ]);
            return response()->json(['message' => 'Participant registered successfully', 'participant' => $participant], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to register participant', 'details' => $th->getMessage()], 500);
        }
    }
}
