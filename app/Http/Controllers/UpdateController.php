<?php

namespace App\Http\Controllers;

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
                $updateArray = array('id' => $champion->id, 'name' => $champion->name, 'key' => $champion->key, 'title' => $champion->title, 'img_link' => $champion->key . ".png");
    			if($checker < 1){
    				DB::table('champions')->insert($updateArray);
    			}
    			else{
    				DB::table('champions')->where('id', $champion->id)->update($updateArray);
    			}
    		}
    	}
        if(Input::has('images')){
            $counter = 0;
            $version = json_decode(file_get_contents("http://ddragon.leagueoflegends.com/realms/na.json"));
            $version = $version->v;
            $champions = json_decode(file_get_contents("https://global.api.pvp.net/api/lol/static-data/na/v1.2/champion?api_key=".$api_key));
            define('CHAMP_DIRECTORY', '/home/forge/default/public/images/champions');
            foreach($champions->data as $champion){
                try{
                    $champ_key = $champion->key;
                    
                    $content = file_get_contents('http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/champion/'.$champ_key.'.png');
                    fopen(CHAMP_DIRECTORY.'/'.$champ_key.'.png', 'w');
                    file_put_contents(CHAMP_DIRECTORY.'/'.$champ_key.'.png', $content);
                }
                catch(\Exception $e){
                    var_dump($e);
                    die();
                }
            }
            $items = json_decode(file_get_contents("https://global.api.pvp.net/api/lol/static-data/na/v1.2/item?api_key=".$api_key));
            define('ITEM_DIRECTORY', '/home/forge/default/public/images/items');
            foreach($items->data as $item){
                try{
                    $item_id = $item->id;
                    
                    $content = file_get_contents('http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/item/'.$item_id.'.png');
                    fopen(ITEM_DIRECTORY.'/'.$item_id.'.png', 'w');
                    file_put_contents(ITEM_DIRECTORY.'/'.$item_id.'.png', $content);
                }
                catch(\Exception $e){
                    var_dump($e);
                    die();
                }
            }
            $profile_icon_ids = DB::table('summoners')->select('profile_icon_id')->whereNotNull('profile_icon_id')->groupBy('profile_icon_id')->get();
            define('PROFILE_DIRECTORY', '/home/forge/default/public/images/profile-icons');
            foreach($profile_icon_ids as $id){
                try{
                    $id = $id->profile_icon_id;
                    
                    $content = file_get_contents('http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/profileicon/'.$id.'.png');
                    fopen(PROFILE_DIRECTORY.'/'.$id.'.png', 'w');
                    file_put_contents(PROFILE_DIRECTORY.'/'.$id.'.png', $content);
                }
                catch(Exception $e){
                    
                }
            }
        }
    	return Redirect::route('admin-updates');
    }







}
