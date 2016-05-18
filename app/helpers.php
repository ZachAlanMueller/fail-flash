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
            foreach($info->participantIdentities as $participantIdentity){ //Go By Participant
                foreach($info->participants as $participant){
                	if($participantIdentity->participantId == $participant->participantId){
		                $count = DB::table('summoner_games')->where('game_id', $game->game_id)->where('summoner_id', $participantIdentity->player->summonerId)->count();
		                if($count < 1){
		                    //insert
		                    DB::table('summoner_games')->insert(array(
		                    	'id' => $participantIdentity->player->summonerId . "-" . $info->matchId ,
								'summoner_id' => $participantIdentity->player->summonerId,
								'champ_id' => $participant->championId,
								'queue' =>  $info->queueType,
								'season' =>  $info->season,
								'game_id' => $info->matchId,
								'team_id' => $participant->teamId,
								'lane' =>  $participant->timeline->lane,
								'role' =>  $participant->timeline->role,
								'timestamp' => $info->matchCreation,
								'item0' => $participant->stats->item0,
								'item1' => $participant->stats->item1,
								'item2' => $participant->stats->item2,
								'item3' => $participant->stats->item3,
								'item4' => $participant->stats->item4,
								'item5' => $participant->stats->item5,
								'item6' => $participant->stats->item6,
								'total_damage_to_champs' => $participant->stats->totalDamageDealtToChampions,
								'magic_damage_to_champs' => $participant->stats->magicDamageDealtToChampions,
								'physical_damage_to_champs' => $participant->stats->physicalDamageDealtToChampions,
								'true_damage_to_champs' => $participant->stats->trueDamageDealtToChampions,
								'kills' => $participant->stats->kills,
								'deaths' => $participant->stats->deaths,
								'assits' => $participant->stats->assists,
								'total_damage_taken' => $participant->stats->totalDamageTaken,
								'magic_damage_taken' => $participant->stats->magicDamageTaken,
								'physical_damage_taken' => $participant->stats->physicalDamageTaken,
								'true_damage_taken' => $participant->stats->trueDamageTaken,
								'wards_placed' => $participant->stats->wardsPlaced,
								'wards_killed' => $participant->stats->wardsKilled,
								'gold_earned' => $participant->stats->goldEarned,
								'minions_killed' => $participant->stats->minionsKilled));
		                }
		                else{
		                    //update
		                }
		            }
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
			print" State Changed in admin table\n";
			die();
		}
	}

	function getDDragonVersion(){
		$version = json_decode(file_get_contents("http://ddragon.leagueoflegends.com/realms/na.json"));
        $version = $version->v;
        return $version;
	}
?>