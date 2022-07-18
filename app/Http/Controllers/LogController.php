<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(){
        /////////////////////////////////////////////
        //////////Log Users viewing Items////////////
        /////////////////////////////////////////////
        foreach (Log::all() as $log) {
            //if field is empty create a new array and add the current user to the array
            if ($log->viewed === false) {
                $array = [];
                $array[] = auth()->user()->id;
                $log->viewed = $array;
                $log->save();
            } elseif (in_array(auth()->user()->id, $log->viewed)) {
                //if user is already in the array ignore this function
            } else {
                //if the user is not in the array but there is an array already created add the current user into the array field
                $array = $log->viewed;
                $array[] = auth()->user()->id;
                $log->viewed = $array;
                $log->save();
            }
        }

    }
}
