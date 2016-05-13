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
    			$checker = DB::table('champions')->where('id', $champion->id)->count();
    			if($checker < 1){
    				DB::table('champions')->insert(array('id' => $champion->id, 'name' => $champion->name, 'key' => $champion->key, 'title' => $champion->title, 'img' => $champion->image->full, 'sprite' => $champions->image->sprite));
    			}
    			else{
    				DB::table('champions')->where('id', $champion->id)->update(array('id' => $champion->id, 'name' => $champion->name, 'key' => $champion->key, 'title' => $champion->title, 'img' => $champion->image->full, 'sprite' => $champions->image->sprite));
    			}
    		}
    	}






    	return Redirect::route('admin-updates');
    }
}
