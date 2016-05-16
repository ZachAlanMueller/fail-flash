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
        var_dump($userInfo);
        die();
    	$userInfo = getUserInfo();
        if ($userInfo->summID != NULL){
            updateSummoner($userInfo->summID);

        	return view('main')
        		->with('userInfo', $userInfo);
        }
        else{
            return Redirect::route('profile-edit')
                ->with('userInfo', $userInfo);
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
