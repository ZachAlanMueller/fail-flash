<?php

	function API_SummonerName($summoner_name){ //https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/Zaedonn?api_key=63d2786a-0782-49c7-a7fd-f1728e6c5071
		try{
			$api_key = getAPI();
			$summoner_name = trim($summoner_name);
			$summoner_name = str_replace(' ', '', strtolower($summoner_name));
			stall();
			$info = json_decode(file_get_contents("https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/".$summoner_name."?api_key=".$api_key));
			$info = $info->$summoner_name;
			return $info;
		}
		catch(Exception $e){
			stall();
			var_dump("Error: ".$e);
			die();
		}
		
	}

	function API_SummonerID($summoner_id){ //https://na.api.pvp.net/api/lol/na/v1.4/summoner/Zaedonn?api_key=63d2786a-0782-49c7-a7fd-f1728e6c5071
		try{
			$api_key = getAPI();
			stall();
			$info = json_decode(file_get_contents("https://na.api.pvp.net/api/lol/na/v1.4/summoner/".$summoner_id."?api_key=".$api_key));
			$info = $info->$summoner_id;
			return $info;
		}
		catch(Exception $e){
			stall();
			print("An Error Occured\n\n" . $e);
			die();
		}
		
	}

	function API_Matchlist($summoner_id){ //https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/23703122?rankedQueues=TEAM_BUILDER_DRAFT_RANKED_5x5,RANKED_SOLO_5x5&seasons=SEASON2016&api_key=
		try{
			$api_key = getAPI();
			stall();
			$info = json_decode(file_get_contents("https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/".$summoner_id."?rankedQueues=TEAM_BUILDER_DRAFT_RANKED_5x5,RANKED_SOLO_5x5&seasons=SEASON2016&api_key=".$api_key));
			$info = $info->matches;
			return $info;
		}
		catch(Exception $e){
			stall();
			print("An Error Occured\n\n" . $e);
			die();
		}
	}

	function API_Match($match_id){ //https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/23703122?rankedQueues=TEAM_BUILDER_DRAFT_RANKED_5x5,RANKED_SOLO_5x5&seasons=SEASON2016&api_key=
		try{
			$api_key = getAPI();
			stall();
			print date("D M d, Y G:i a");
			$info = json_decode(file_get_contents("https://na.api.pvp.net/api/lol/na/v2.2/match/".$match_id."?includeTimeline=true&api_key=".$api_key));
			return $info;
		}
		catch(Exception $e){
			stall();
			if (strpos($e, '404 Not Found') !== false) {
				return 404;
			}
			elseif (strpos($e, '500 Server Error') !== false){
				return 500;
			}
			elseif(strpos($e, '504 GATEWAY_TIMEOUT') != false){
				return 504;
			}
			else{
				print "An Error Occured!!!!!: \n\n" . $e;
				die();
			}

		}
	}













?>