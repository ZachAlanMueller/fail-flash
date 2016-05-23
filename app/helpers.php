<?php
// My common functions

	function isAdmin($user)
	{
	    if($user->group == 'admin'){
	    	return true;
	    }
	    else {
	    	return false;
	    }
	}
	function getUserInfo(){
		$user = Auth::user();
		$userInfo = new stdClass();
    	if(Auth::check()){
    		$user = Auth::user();
    		$userInfo->name = $user->name;
    		$userInfo->group = $user->group;
    		$userInfo->summoner_id = $user->summoner_id;
    	}
    	return $userInfo;
	}

	// ------------- API CALL HELPERS ------------- \\
	function getAPI(){
		return '63d2786a-0782-49c7-a7fd-f1728e6c5071';
	}
	function stall(){
		$state = DB::table('admin')->where('id', 1)->get();
		$state = $state[0]->state;
		if($state == 1){
			sleep(2);
			return;
		}
		else{
			print" State Changed in admin table\n";
			die();
		}
	}

	function getDDragonVersion(){
		$version = json_decode(file_get_contents("http://ddragon.leagueoflegends.com/realms/na.json"));
        $version = $version->v;
        return $version;
	}

	function softUpdate($summoner_id){
		var_dump(date('m/d/Y h:i:s a', time()));
		die();
		// --- --- --- --- --- --- --- --- --- --- 
		$info = API_SummonerID($summoner_id);
		$count = DB::table('summoners')->where('id', $summoner_id)->count();
		$infoArray = array('name' => $info->name, 'id' => $info->id, 'profile_icon_id' => $info->profileIconId);
		if($count == 0){
			DB::table('summoners')->insert($infoArray);
		}
		else{
			DB::table('summoners')->where('id', $summoner_id)->update($infoArray);
		}
		// --- --- --- --- --- --- --- --- --- --- 
		$info = API_League($summoner_id);
		$count = DB::table('summoners')->where('id', $summoner_id)->count();
		$infoArray = array();
		foreach($info as $region){
			if($region->queue == "RANKED_SOLO_5x5"){
				foreach($region->entries as $user){
					$count = DB::table('summoners')->where('id', $user->playerOrTeamId)->count();
					$infoArray = array('name' => $user->playerOrTeamName, 'id' => $user->playerOrTeamId, 'league_points' => $user->leaguePoints, 'division' => $user->division, 'tier' => $region->tier, 'last_update' => date('m/d/Y h:i:s a', time()), 'tier_name' $region->name);
					if($count == 0){
						DB::table('summoners')->insert($infoArray);
					}
					else{
						DB::table('summoners')->where('id', $user->playerOrTeamId)->update($infoArray);
					}
				}
			}
		}
		$info = API_Matchlist($summoner_id);
		foreach($info as $game){
			$count = DB::table('games')->where('id', $game->matchId)->count();
            if($count == 0){
                DB::table('games')->insert(array('id' => $game->matchId));
            }
            $count = DB::table('summoner_games')->where('game_id', $game->matchId)->where('summoner_id', $summoner_id)->count();
            $userInfo = array('id' => $summoner_id . "-" . $game->matchId, 'summoner_id' => $summoner_id, 'champ_id' => $game->champion, 'role' => $game->role, 'lane' => $game->lane, 'timestamp' => $game->timestamp, 'queue' => $game->queue, 'season' => $game->season, 'game_id' => $game->matchId);
            if($count < 1){
                DB::table('summoner_games')->insert($userInfo);
            }
            else{
                DB::table('summoner_games')->where('id', $summoner_id . '-' . $game->matchId)->update($userInfo);
            }
		}






	}
















?>