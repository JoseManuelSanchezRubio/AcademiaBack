<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Course;
use App\Models\Professor;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
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
        $professor = Professor::findOrFail($request->professor_id);
        $course = Course::findOrFail($request->course_id);

        $announcement = new Announcement();
        $announcement->title=$request->title;
        $announcement->body=$request->body;
        $announcement->professor()->associate($professor);
        $announcement->course()->associate($course);
        $announcement->save();

        return $announcement;
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        //
    }

    public function getAnnouncementsByCourse(Request $request){
        $announcements = Announcement::get();

        $array=[];
        foreach($announcements as $announcement){
            if($announcement->course_id == $request->course_id){
                $array[]=[
                    'id'=>$announcement->id,
                    'title'=>$announcement->title,
                    'body'=>$announcement->body
                ];

            }
        }
        return response()->json($array);
    }
}
