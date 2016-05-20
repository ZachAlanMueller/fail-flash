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
            $userInfo = getUserInfo();
            $summoner_id = $userInfo->summoner_id;
            $recentGames = DB::raw('select * from summoner_games sg join champions c on c.id = sg.champ_id where summoner_id = 23703122 order by game_id desc limit 10')->get();
            var_dump($recentGames);
            die();
            return view('main')
                ->with('userInfo', $userInfo);
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
