<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Auth;
use stdClass;
use DB;
use App\Http\Requests;

class APIController extends Controller
{
    public function databaseUpdates() {
    	$api_key = getAPI();
    	if(Input::has('champions')){
    		$champions = json_decode(file_get_contents('https://global.api.pvp.net/api/lol/static-data/na/v1.2/champion?champData=image,info,skins&api_key='.$api_key));
    		foreach($champions->data as $champion){
    			var_dump($champion);
    			die();

    		}
    	}






    	return Redirect::route('admin-updates');
    }
}
