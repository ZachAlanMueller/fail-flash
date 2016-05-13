<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Auth;
use stdClass;
use DB;
use App\Http\Requests;

class AdminController extends Controller
{
    public function updates() {
    	$user = Auth::user();
    	
    	$isAdmin = isAdmin($user);
	    if($isAdmin){
	    	return view('adminUpdates')
	    	->with('userInfo', $userInfo);
	    }
	    else{
	    	return Redirect::route('home');
	    }
	}
}
