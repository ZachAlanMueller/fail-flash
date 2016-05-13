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
    public function home()
    {
    	$userInfo = new stdClass();
    	if(Auth::check()){
    		$user = Auth::user();
    		$userInfo->name = $user->name;
    		$userInfo->group = $user->group;
    	}



    	return view('main')
    		->with('userInfo', $userInfo);
    }
    public function redirectHome(){
    	return Redirect::route('home');
    }
    public function searchSummoner(){
    	$form = Input::all('post');
        $name = $form['search']; 
    	print $name;
    }
}
