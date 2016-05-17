<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Auth;
use stdClass;
use DB;
use App\Http\Requests;

class updateSummoner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateSummoner {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a summoner';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->argument();
        $id = $arguments['id'];
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
}
