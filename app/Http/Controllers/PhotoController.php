<?php

namespace App\Http\Controllers;


use App\User;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make(
            $request->all(),
            ['photo'=>
            'required|image|mimes:jpg,jpeg,png']
        );
        if ($v->fails()) {
            return response()
                    ->json($v->messages(), 422);
        }
        $name = time().'.'.$request->photo->extension();
        $url = url('images/'.$name);
        $request->photo->move(
            public_path('images'),
            $name
        );
        $token = $request->header('token');
        $user = User::where('api_token', $token)->first();
        $photo = new Photo;
        $photo->name = 'Untitled'; 
        $photo->url = $url;
        $photo->owner_id = $user->id;
        $photo->save();
        return response()->json([
            'id'=> $photo->id,
            'name'=> $photo->name,
            'url'=> $photo->url
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
    }
}
