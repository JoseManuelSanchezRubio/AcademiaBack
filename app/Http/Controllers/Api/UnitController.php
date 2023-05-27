<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Course;
use App\Models\Forum;
use App\Models\UserUpload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();

        return $units;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //verificar que no se repita el nombre
    {
        $base64=$request->theory_file;
        $data=substr($base64, strpos($base64, ',')+1);
        $data=base64_decode($data);
        Storage::disk('public')->put($request->theory, $data);

        $base64=$request->exercises_file;
        $data=substr($base64, strpos($base64, ',')+1);
        $data=base64_decode($data);
        Storage::disk('public')->put($request->exercises, $data);


        $forum = new Forum();
        $unit = new Unit();

        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->theory = $request->theory;
        $unit->exercises = $request->exercises;
        $course = Course::findOrFail($request->course_id);
        $unit->course()->associate($course);

        $unit->save();

        $forum->save();

        $forum->unit_id = $unit->id;

        $unit->forum_id = $forum->id;

        $unit->save();

        $forum->save();

        return $unit;
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        //
    }

    public function postUpload(Request $request){
        $userUpload = new UserUpload();
        $user = User::findOrFail($request->user_id);
        $unit = Unit::findOrFail($request->unit_id);

        $base64=$request->file;
        $data=substr($base64, strpos($base64, ',')+1);
        $data=base64_decode($data);
        Storage::disk('public')->put($request->file_name, $data);

        $userUpload->user()->associate($user);
        $userUpload->unit()->associate($unit);
        $userUpload->file_name=$request->file_name;

        $userUpload->save();

        return $userUpload;
    }
    public function getUploadsByUser(Request $request){
        $uploads = UserUpload::get();
        $array=[];
        foreach($uploads as $upload){
            if($upload->user_id == $request->user_id){
                $array[]=[
                    'id'=>$upload->id,
                    'user'=>$upload->user,
                    'unit'=>$upload->unit,
                    'file_name'=>$upload->file_name
                ];
            }
        }
        return $array;
    }
}
