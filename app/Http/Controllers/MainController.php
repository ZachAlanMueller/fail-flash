<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
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
    public function searchSummoner(){
    	$name = Input::all('post');
        
    	var_dump($name);
    	die();
    }
}
