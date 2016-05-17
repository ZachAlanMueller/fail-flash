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



	function updateSummonerById($id){
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
                $playerNumber = $participant->participantId;
                $count = DB::table('summoner_games')->where('game_id', $game->game_id)->where('summoner_id', $participant->player->summonerId)->count();
                if($count < 1){
                    //insert
                    DB::table('summoner_games')->insert(array(
                    	'id' => $participant->player->summonerId . "-" . $game->game_id ,
						'summoner_id' => $participant->player->summonerId,
						'champ_id' => $info->participants->{$playerNumber}->championId,
						'queue' =>  $info->queueType,
						'season' =>  $info->season,
						'game_id' => $info->matchId,
						'lane' =>  $info->participants->{$playerNumber}->stats->lane,
						'role' =>  $info->participants->{$playerNumber}->stats->role,
						'timestamp' => $info->matchCreation,
						'item0' => $info->participants->{$playerNumber}->stats->item0,
						'item1' => $info->participants->{$playerNumber}->stats->item1,
						'item2' => $info->participants->{$playerNumber}->stats->item2,
						'item3' => $info->participants->{$playerNumber}->stats->item3,
						'item4' => $info->participants->{$playerNumber}->stats->item4,
						'item5' => $info->participants->{$playerNumber}->stats->item5,
						'item6' => $info->participants->{$playerNumber}->stats->item6,
						'total_damage_to_champs' => $info->participants->{$playerNumber}->stats->totalDamageDealtToChampions,
						'magic_damage_to_champs' => $info->participants->{$playerNumber}->stats->magicDamageDealtToChampions,
						'physical_damage_to_champs' => $info->participants->{$playerNumber}->stats->physicalDamageDealtToChampions,
						'true_damage_to_champs' => $info->participants->{$playerNumber}->stats->trueDamageDealtToChampions,
						'kills' => $info->participants->{$playerNumber}->stats->kills,
						'deaths' => $info->participants->{$playerNumber}->stats->deaths,
						'assits' => $info->participants->{$playerNumber}->stats->assists,
						'total_damage_taken' => $info->participants->{$playerNumber}->stats->totalDamageTaken,
						'magic_damage_taken' => $info->participants->{$playerNumber}->stats->magicDamageTaken,
						'physical_damage_taken' => $info->participants->{$playerNumber}->stats->physicalDamageTaken,
						'true_damage_taken' => $info->participants->{$playerNumber}->stats->trueDamageTaken,
						'wards_placed' => $info->participants->{$playerNumber}->stats->wardsPlaced,
						'wards_killed' => $info->participants->{$playerNumber}->stats->wardsKilled,
						'gold_earned' => $info->participants->{$playerNumber}->stats->goldEarned,
						'minions_killed' => $info->participants->{$playerNumber}->stats->mnionsKilled));
                }
                else{
                    //update
                }
            }        
        }
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
			die();
		}
	}

	function getDDragonVersion(){
		$version = json_decode(file_get_contents("http://ddragon.leagueoflegends.com/realms/na.json"));
        $version = $version->v;
        return $version;
	}
?>