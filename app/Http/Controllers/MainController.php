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
        $files = glob($dir . '/images/posters/*.*');
        $file = array_rand($files);
        $img_link = $files[$file];
        return view('main')
            ->with('img_link', $img_link);
    }

    public function redirectHome(){
    	return Redirect::route('home');
    }

    public function searchSummoner(){
    	$form = Input::all('post');
        $name = $form['search']; 
    	print $name;
    }

    public function updateSummonerById($id){
        updateSummoner($id);
        var_dump('Done');
        die();
    }












    public function editProfile(){
        $user = Auth::user();
        var_dump($user->id);
        die();
    }
    public function saveProfile(){

    }
}
