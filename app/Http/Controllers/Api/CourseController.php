<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Professor;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses=Course::get();
        $array=[];
        foreach($courses as $course){
            $array[]=[
                'id'=>$course->id,
                'name'=>$course->name,
                'description'=>$course->description,
                'price'=>$course->price,
                'theory'=>$course->theory,
                'theory_link'=>Storage::url($course->theory),
                'exercises'=>$course->exercises,
                'exercises_link'=>Storage::url($course->exercises),
                'units'=>$course->units,
                'users'=>$course->users,
                'professor'=>$course->professor
            ];
        }
        return response()->json($array);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $courses=Course::get();

        foreach($courses as $_course){
            if($_course->name == $request->name){
                return response()->json(['status'=>false, 'message'=>'El nombre ya existe en la base de datos']);
            }
        }

        $professor = Professor::findOrFail($request->professor_id);
        $course = new Course();
        $course->name=$request->name;
        $course->description=$request->description;
        $course->price=$request->price;
        $course->professor()->associate($professor);
        $course->save();

        return response()->json(['status'=>true, 'course'=>$course]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $array=[];
        $array[]=[
            'id'=>$course->id,
            'name'=>$course->name,
            'description'=>$course->description,
            'price'=>$course->price,
            'theory'=>$course->theory,
            'exercises'=>$course->exercises,
            'units'=>$course->units,
            'users'=>$course->users,
        ];

        /* foreach($course->units as $unit){

        } */


        return response()->json($array);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        Course::findOrFail($course->id)->delete();
        $courses=Course::get();
        $array=[];
        foreach($courses as $course){
            $array[]=[
                'id'=>$course->id,
                'name'=>$course->name,
                'description'=>$course->description,
                'price'=>$course->price,
                'theory'=>$course->theory,
                'theory_link'=>Storage::url($course->theory),
                'exercises'=>$course->exercises,
                'exercises_link'=>Storage::url($course->exercises),
                'units'=>$course->units,
                'users'=>$course->users,
                'professor'=>$course->professor
            ];
        }
        return response()->json($array);
    }

    public function users(Request $request){
        $course=Course::find($request->course_id);
        $users=$course->users;
        return response()->json($users);
    }
}
