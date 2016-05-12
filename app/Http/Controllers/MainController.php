<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;

class MainController extends Controller
{
    public function home()
    {
    	return view('main');
    }
    public function redirectHome(){
    	 return Redirect::route('home');
    }
    public function searchSummoner($name){
    	var_dump($name);
    	die();
    }
}
