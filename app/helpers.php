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
    		$userInfo->summID = $user->summoner_id;
    	}
    	return $userInfo;
	}

	function updateSummoner($id){

	}

	function getAPI(){
		return '63d2786a-0782-49c7-a7fd-f1728e6c5071';
	}


	function getDDragonVersion(){
		$version = json_decode(file_get_contents("http://ddragon.leagueoflegends.com/realms/na.json"));
        $version = $version->v;
        return $version;
	}
?>