<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
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
        $message = new Message();
        $message->body=$request->body;
        $forum = Forum::findOrFail($request->forum_id);
        $message->forum()->associate($forum);
        $user = User::findOrFail($request->user_id);
        $message->user()->associate($user);
        $message->save();
        return $message;
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }

    public function getMessagesByForum(Request $request){
        $messages=Message::get();

        $array=[];
        foreach($messages as $message){
            if($message->forum_id == $request->forum_id){
                $array[]=[
                    'id'=>$message->id,
                    'body'=>$message->body,
                    'user_id'=>$message->user_id,
                    'user'=>$message->user,
                    'created_at'=>$message->created_at
                ];

            }
        }
        return response()->json($array);
    }
}
