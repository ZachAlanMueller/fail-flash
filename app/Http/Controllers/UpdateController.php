<?php

namespace App\Http\Controllers\UpdateController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Auth;
use stdClass;
use DB;
use App\Http\Requests;

class UpdateController extends Controller
{
    public function databaseUpdates() {
    	$api_key = getAPI();
    	if(Input::has('champions')){
    		$champions = json_decode(file_get_contents('https://global.api.pvp.net/api/lol/static-data/na/v1.2/champion?champData&api_key='.$api_key));
    		foreach($champions->data as $champion){
    			$checker = DB::table('champions')->where('id', $champion->id)->count();
    			if($checker < 1){
    				DB::table('champions')->insert(array('id' => $champion->id, 'name' => $champion->name, 'key' => $champion->key, 'title' => $champion->title));
    			}
    			else{
    				DB::table('champions')->where('id', $champion->id)->update(array('id' => $champion->id, 'name' => $champion->name, 'key' => $champion->key, 'title' => $champion->title));
    			}
    		}
    	}
    	return Redirect::route('admin-updates');
    }

    public function updateSummonerById($id){
        $summonerInfo = API_SummonerID($id);
        $count = DB::table('summoners')->where('id', $summonerInfo->id)->count();
        if($count < 1){
            DB::table('summoners')->insert(array('name' => $summonerInfo->name, 'id' => $summonerInfo->id, 'profile_icon_id' => $summonerInfo->profileIconId));
        }
        else{
            DB::table('summoners')->where('id', $summonerInfo->id)->update(array('name' => $summonerInfo->name, 'id' => $summonerInfo->id, 'profile_icon_id' => $summonerInfo->profileIconId));
        }
        $summonerGames = API_Matchlist($id);
        foreach($summonerGames as $game){
            $count = DB::table('summoner_games')->where('game_id', $game->matchId)->count();
            if($count < 1){
                DB::table('summoner_games')->insert(array('id' => $id . "-" . $game->matchId, 'summoner_id' => $id, 'champ_id' => $game->champion, 'role' => $game->role, 'lane' => $game->lane, 'timestamp' => $game->timestamp, 'queue' => $game->queue, 'season' => $game->season, 'game_id' => $game->matchId));
            }
            else{
                DB::table('summoner_games')->where('id', $id . '-' . $game->matchId)->update(array('id' => $id . "-" . $game->matchId, 'summoner_id' => $id, 'champ_id' => $game->champion, 'role' => $game->role, 'lane' => $game->lane, 'timestamp' => $game->timestamp, 'queue' => $game->queue, 'season' => $game->season, 'game_id' => $game->matchId));
            }
        }

        $games = DB::table('summoner_games')->where('summoner_id', $id)->get();//Get All Games...
        foreach($games as $game){   //Go By Game
            $info = API_Match($game->game_id);
            foreach($info->participantIdentities as $participant){ //Go By Participant
                $playerNumber = $participant;
                var_dump($playerNumber);
                die();
                $count = DB::table('summoner_games')->where('game_id', $game->game_id)->where('summoner_id', $participant->player->summonerId)->count();
                if($count < 1){
                    //insert
                    DB::table('summoner_games')->insert(array())
                }
                else{
                    //update
                }
            }        
        }
    }
    
    public function updatesummonerByName($name){

    }







}
