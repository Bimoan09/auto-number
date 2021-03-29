<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Date;
use Carbon\Carbon;

class DateController extends Controller
{
    public function getDate(){
        $data = Date::get();

       
        

        return view('welcome', compact('data'));


    }

    public function postDate(Request $request){
        $data = new Date;

        $parsing = str_replace('/', '-', $request->date);
        $newDate = date("Y-m-d", strtotime($parsing));
        $formatDate = substr($newDate, 5, 2);
    
        $data->date = $newDate;

        $getData = Date::whereMonth('date', $formatDate)->count();
        $triger = $getData + 1;
    
        $formatDate = substr($newDate, 2, 5);
        $removeSymbol =  preg_replace("/[^0-9]/", "", $formatDate);
        $serial_number = "MSK/" . $removeSymbol . "/" ."000" .$triger;

        $data->serial_number = $serial_number;
        $data->save();
        return response()->json(['success'=>'Date saved successfully.']);
    }
}
