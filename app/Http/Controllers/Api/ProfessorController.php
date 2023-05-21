<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use \stdClass;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professors=Professor::get();
        $array=[];
        foreach($professors as $professor){
            $array[]=[
                'id'=>$professor->id,
                'name'=>$professor->name,
                'surname'=>$professor->surname,
                'dni'=>$professor->dni,
                'address'=>$professor->address,
                'phone'=>$professor->phone,
                'email'=>$professor->email,
                'courses'=>$professor->courses,
            ];
        }
        return response()->json($array);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $professors=Professor::get();

        foreach($professors as $professor){
            if($professor->email == $request->email){
                return response()->json(['status'=>false, 'message'=>'El email ya existe en la base de datos']);
            }
            if($professor->dni == $request->dni){
                return response()->json(['status'=>false, 'message'=>'El dni ya existe en la base de datos']);
            }
        }

        $professor=new Professor();
        $professor->name=$request->name;
        $professor->surname=$request->surname;
        $professor->dni=$request->dni;
        $professor->address=$request->address;
        $professor->phone=$request->phone;
        $professor->email=$request->email;
        $professor->password=Hash::make($request->password);
        $professor->role='1';
        $professor->save();

        $token=$professor->createToken('auth_token')->plainTextToken;

        return response()->json(['professor'=>$professor, 'token'=>$token, 'token_type'=>'Bearer', 'status'=>true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Professor $professor)
    {
        $data=[
            'professor' => $professor,
            'courses' => $professor->courses
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Professor $professor)
    {
        if($request->name) $professor->name=$request->name;
        if($request->surname) $professor->surname=$request->surname;
        //if($request->dni) $professor->dni=$request->dni;
        if($request->address) $professor->address=$request->address;
        if($request->phone) $professor->phone=$request->phone;
        if($request->email) $professor->email=$request->email;
        if($request->password) $professor->password=Hash::make($request->password);

        $professor->save();

        return response()->json($professor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professor $professor)
    {
        $professor->delete();
        return response()->json($professor);
    }

    public function login(Request $request){

        if(!Auth::guard('professor')->attempt($request->only(['email','password']))){
            return response()->json(['message'=>'Usuario y contraseña incorrectos', 'status'=>false]);
        }

        foreach (Professor::all() as $_professor) {
            if($_professor->email == $request->email){
                $professor=$_professor;
            }
        }
        $token=$professor->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'professor' => $professor,
            'status'=>true
        ]);


    }
}
