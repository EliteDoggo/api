<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class Auth extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'phone'=>'required',
            'password'=>'required'
            
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->messages(),422);
              
        }

        $token = Str::substr($request->api_token, 7);

        $data = User::where(['phone' => $request->phone])->first();
        if (Hash::check($request->password, $data->password)) {
            $data->api_token = Str::random(80);
            $data->save();
            return response()->json([
                'token' => $data->api_token
            ],200);
        }
        else {
            return response()->json('Логин или пароль неверный', 404);
        }
      


    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('api_token', $token)->first();
        $user->api_token = '';
        $user->save();
        return response()->json([], 200);
       
    }




    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'phone'=>'required|unique:users',
            'first_name'=>'required',
            'surname'=>'required',
            'password'=>'required'
            
        ]);


        if ($validator->fails()) {
            return response()->json($validator->messages(),422);
              
        }

        $user = new User();
        $user->first_name = $request->first_name;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->surname = $request->surname;
        $user->remember_token = Str::random(80);
        $user->save();

        return response()->json([
            'id' => $user->id

        ],201);

    }


    public function user(Request $request){

        $s = explode(' ', $request->search);

        $user = User::select('id', 'first_name', 'surname', 'phone');

        for ($i=0; $i < count($s); $i++) {
            
            $user->orWhere('first_name', 'like', '%'.$s[$i].'%')
                    ->orWhere('surname', 'like', '%'.$s[$i].'%')
                    ->orWhere('phone', 'like', '%'.$s[$i].'%');
        }

        return response()->json($user->get(), 200);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
