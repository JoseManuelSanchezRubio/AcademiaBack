<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = new Event();
        $event->title=$request->title;
        $event->description=$request->description;
        $event->start_date=$request->start_date;
        $event->end_date=$request->end_date;
        $user = User::findOrFail($request->user_id);
        $event->user()->associate($user);
        $event->save();
        return $event;
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json($event);
    }

    public function getEventsByUser(Request $request){
        $events=Event::get();

        $array=[];
        foreach($events as $event){
            if($event->user_id == $request->user_id){
                $array[]=[
                    'id'=>$event->id,
                    'title'=>$event->title,
                    'description'=>$event->description,
                    'start_date'=>$event->start_date,
                    'end_date'=>$event->end_date
                ];

            }
        }
        return response()->json($array);
    }
}