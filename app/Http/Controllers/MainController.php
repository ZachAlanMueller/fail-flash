<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Auth;
use stdClass;
use DB;
use App\Http\Requests;
use Carbon\Carbon;

class MainController extends Controller
{
    public function landingPage()
    {
        //Description:
        // Landing page that currently displayes a random poster image.
        $files = glob(base_path().'/public/images/posters/*.*');
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
    public function requestedUpdate(){
      $id = Input::all('post');
      $id = $id['id'];
      softUpdate($id);
      $response = array('status' => 'success', 'msg' => 'Soft Update Completed');
      return Response::json($response);
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
        $now = Carbon::now();
        DB::table('summoners')->where('id', $id)->update(array('viewed' => $now));
        $summonerInfo = DB::table('summoners')->where('id', $id)->get();
        $summonerInfo = $summonerInfo[0];
        $summonerInfo->profile_img_link = "/images/profile-icons/".$summonerInfo->profile_icon_id.".png";
        $summonerInfo->badge_img_link = "/images/badges/".ucwords(strtolower($summonerInfo->tier)).".png";
        // Link to images for Rank-Badge and Profile Icon

        //A super awesome 1-query join could cause excess time.  Best to just join games to all of them and reference them all by game ID
        //try just 'last game'
        $champions = new stdClass();
        $colors = array("3C8D2F","63A358","8ABA82","B1D1AB","D8E8D5","FFFFFF","E9BFBF","D47F7F","BF3F3F","AA0000");

        $temp = DB::table('summoner_games')
          ->join('champions', 'champions.id', '=', 'summoner_games.champion_id')
          ->select(DB::raw('avg(winner) * 100 as win_percent, count(*) as number_games, name, img_link'))
          ->where('summoner_id', $summonerInfo->id)
          ->groupBy('champion_id')
          ->orderBy('number_games', 'desc')
          ->get();
        $champions->topPlayed = $temp;

        $temp = DB::table('summoner_games')
          ->join('champions', 'champions.id', '=', 'summoner_games.champion_id')
          ->select(DB::raw('avg(winner) * 100 as win_percent, count(*) as number_games, name, img_link'))
          ->where('summoner_id', $summonerInfo->id)
          ->whereNotNull('winner')
          ->groupBy('champion_id')
          ->having('number_games', '>', 4)
          ->orderBy('win_percent', 'desc')
          ->limit(5)
          ->get();
        $champions->topWinners = $temp;


        if(Auth::check()){
            $userInfo = getUserInfo();
            return view('displaySummoner')
                ->with('userInfo', $userInfo)
                ->with('summonerInfo', $summonerInfo)
                ->with('champions', $champions)
                ->with('colors', $colors);
        }
        else{
            return view('displaySummoner')
              ->with('summonerInfo', $summonerInfo)
              ->with('champions', $champions)
              ->with('colors', $colors);
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
