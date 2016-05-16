<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Auth;
use stdClass;
use DB;
use App\Http\Requests;

class MainController extends Controller
{
    public function landingPage()
    {
        if(Auth::check()){
            return view('main'); // user IS logged in
        }
    	else{
            return view('main');
        }
    }

    public function redirectHome(){
    	return Redirect::route('home');
    }

    public function searchSummoner(){
    	$form = Input::all('post');
        $name = $form['search']; 
    	print $name;
    }

    public function editProfile(){
        $user = Auth::user();
        var_dump($user->id);
        die();
    }
    public function saveProfile(){

    }
}
