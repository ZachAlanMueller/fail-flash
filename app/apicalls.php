<?php

	function API_Summoner($summoner_name){ //https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/Zaedonn?api_key=63d2786a-0782-49c7-a7fd-f1728e6c5071
		try{
			$api_key = getAPI();
			$summoner_name = trim($summoner_name);
			$summoner_name = str_replace(' ', '', strtolower($summoner_name));
			$info = json_decode(file_get_contents("https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/".$summoner_name."?api_key=".$api_key));
			$info = $info->$summoner_name;
			return $info;
		}
		catch(Exception $e){

		}
		
	}

	function API_Matchlist($summoner_id){ //https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/23703122?rankedQueues=TEAM_BUILDER_DRAFT_RANKED_5x5,RANKED_SOLO_5x5&seasons=SEASON2016&api_key=

	}
?>