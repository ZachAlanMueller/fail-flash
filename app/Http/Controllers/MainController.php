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
        //Description:
        // Landing page that currently displayes a random poster image. 
        $files = glob('/home/forge/default/public/images/posters/*.*');
        $file = array_rand($files);
        $img_link =  $files[$file];
        $pos = strpos($img_link, '/images');
        $img_link = substr($img_link, $pos);
        if(Auth::check()){
            $userInfo = getUserInfo();
            return view('main')
                ->with('img_link', $img_link)
                ->with('userInfo', $userInfo);
        }
        return view('main')
            ->with('img_link', $img_link);
    }

    public function redirectHome(){
    	return Redirect::route('home');
    }

    public function searchSummoner(){
    	$form = Input::all('post');
        $name = $form['search']; 
    	$summoner = DB::table('summoners')->where('name', $name)->get();
        if(empty($summoner)){
            $summonerAPI = API_SummonerName($name);
            softUpdate($summonerAPI->id);
            return Redirect('/summoner/'.$summonerAPI->id);
        }
        else{
            return Redirect('/summoner/'.$summoner[0]->id);
        }
    }

    public function softUpdate($id){
        softUpdate($id);
        return Redirect('/summoner/'.$id);
    }
    public function mediumUpdate($id){
        mediumUpdate($id);
        return Redirect('/summoner/'.$id);
    }
    public function hardUpdate($id){
        hardUpdate($id);
        return Redirect('/summoner/'.$id);
    }

    public function displaySummoner($id){
        $summonerInfo = DB::table('summoners')->where('id', $id)->get();
        $summonerInfo = $summonerInfo[0];
        $summonerInfo->profile_img_link = "/images/profile-icons/".$summonerInfo->profile_icon_id.".png";
        $summonerInfo->badge_img_link = "/images/badges/".ucwords(strtolower($summonerInfo->tier)).".png";
        // Link to images for Rank-Badge and Profile Icon
        
        //A super awesome 1-query join could cause excess time.  Best to just join games to all of them and reference them all by game ID
        //try just 'last game'
        $latestGameId = DB::table('summoner_games')->select('game_id')->where('summoner_id', $id)->orderBy('game_id', 'desc')->limit(1)->get();
        var_dump($latestGameId);
        die();

        
        if(Auth::check()){
            $userInfo = getUserInfo();
            return view('displaySummoner')
                ->with('userInfo', $userInfo)
                ->with('summonerInfo', $summonerInfo);
        }
        else{
            return view('displaySummoner')
                ->with('summonerInfo', $summonerInfo);
        }
    }












    public function editProfile(){
        $user = Auth::user();
        var_dump($user->id);
        die();
    }
    public function saveProfile(){

    }
}
