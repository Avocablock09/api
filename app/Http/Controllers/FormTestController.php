<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormTestController extends Controller
{
    //
    public function index(){
        return '
        <form action="/form" method="POST">
            <input type="text" name="lat">
            <button type="submit">Submit</button>
        </form>';
    }

    public function tampilGet(request $request){
        return $request->lat;
    }
}
