<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    //

    public function show (Request $request){

        $user = $request->user();
        $user->load('driver');
        return $user;
    }

    public function update(Request $request){
        $request->validate([
            'year'=>'required|numeric|between:2000,2030',
            'make'=>'required',
            'model'=>'required',
            'color'=>'required|alpha',
            'license_plate'=>'required',
            'name'=>'required'
        ]);

        $user = $request->user();
        $user->update($request->only('name'));

        $user->driver()->updateOrCreate($request->only([
            'year',
            'make',
            'model',
            'color',
            'license_plate'
        ]));

        $user->load('driver');
        return $user;


    }
}
