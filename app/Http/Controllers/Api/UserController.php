<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use \stdClass;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::get();
        $array=[];
        foreach($users as $user){
            $array[]=[
                'id'=>$user->id,
                'name'=>$user->name,
                'surname'=>$user->surname,
                'dni'=>$user->dni,
                'address'=>$user->address,
                'phone'=>$user->phone,
                'email'=>$user->email,
                'courses'=>$user->courses,
            ];
        }
        return response()->json($array);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $users=User::get();

        foreach($users as $user){
            if($user->email == $request->email){
                return response()->json(['status'=>false, 'message'=>'El email ya existe en la base de datos']);
            }
            if($user->dni == $request->dni){
                return response()->json(['status'=>false, 'message'=>'El dni ya existe en la base de datos']);
            }
        }

        $user=new User();
        $user->name=$request->name;
        $user->surname=$request->surname;
        $user->dni=$request->dni;
        $user->address=$request->address;
        $user->phone=$request->phone;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->role='0';
        $user->save();

        $token=$user->createToken('auth_token')->plainTextToken;

        return response()->json(['user'=>$user, 'token'=>$token, 'token_type'=>'Bearer', 'status'=>true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $data=[
            'user' => $user,
            'courses' => $user->courses
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->name=$request->name;
        $user->surname=$request->surname;
        $user->dni=$request->dni;
        $user->address=$request->address;
        $user->phone=$request->phone;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json($user);
    }

    public function attach(Request $request){
        $user=User::find($request->user_id);
        $user->courses()->attach($request->course_id);
        return response()->json($user);
    }

    public function detach(Request $request){
        $user=User::find($request->user_id);
        $user->courses()->detach($request->course_id);
        return response()->json($user);
    }

    public function login(Request $request){

        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json(['message'=>'Usuario y contraseña incorrectos', 'status'=>false]);
        }
        //$user=User::where('email', $request->email->first());   no sé por qué no coge el user de esta manera

        foreach (User::all() as $_user) {
            if($_user->email == $request->email){
                $user=$_user;
            }
        }
        $token=$user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'status'=>true
        ]);


    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return 'Cierre de sesión';
    }
}
