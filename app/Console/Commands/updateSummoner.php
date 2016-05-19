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
            if(is_int($info)){
                continue;
            }
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
                                'minions_killed' => $participant->stats->minionsKilled,
                                'participant_id' => $participant->participantId));
                        }
                        else{
                            DB::table('summoner_games')->where('id', $participantIdentity->player->summonerId . "-" . $info->matchId)->update(array(
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
                                'minions_killed' => $participant->stats->minionsKilled,
                                'participant_id' => $participant->participantId));
                        }
                    }
                }
            } 
            foreach($info->timeline->frames as $frame){
                foreach($frame->participantFrames as $pFrame){
                    $count = DB::table('frames')->where('id', $info->matchId . '-' . $frame->timestamp . '-' . $pFrame->participantId)->count();
                    if($count < 1){
                        DB::table('frames')->insert(array(
                            'id' => $info->matchId . "-" . $frame->timestamp . "-" . $pFrame->participantId,
                            'game_id' => $info->matchId,
                            'participant_id' => $pFrame->participantId,
                            'timestamp' => $frame->timestamp,
                            'current_gold' => $pFrame->currentGold,
                            'total_gold' => $pFrame->totalGold,
                            'minions_killed' => $pFrame->minionsKilled,
                            'level' => $pFrame->level,
                            'xp' => $pFrame->xp));
                    }
                    else{
                        DB::table('frames')->where('id', $info->matchId .'-' .$frame->timestamp . '-' . $pFrame->participantId)->update(array(
                            'id' => $info->matchId . "-" . $frame->timestamp . "-" . $pFrame->participantId,
                            'game_id' => $info->matchId,
                            'participant_id' => $pFrame->participantId,
                            'timestamp' => $frame->timestamp,
                            'current_gold' => $pFrame->currentGold,
                            'total_gold' => $pFrame->totalGold,
                            'minions_killed' => $pFrame->minionsKilled,
                            'level' => $pFrame->level,
                            'xp' => $pFrame->xp));
                    }
                }
                if(isset($frame->events)){
                    foreach($frame->events as $eventId => $event){
                        $count = DB::table('frame_events')->where('id', $info->matchId . '-' . $eventId . '-' . $event->timestamp)->count();
                        $arrayTemp = array(
                                'id' => $info->matchId . '-' . $eventId . '-' . $event->timestamp,
                                'game_id' => $info->matchId,
                                'event_type' => $event->eventType,
                                'timestamp' => $event->timestamp,
                                'event_id' => $eventId);
                        if(isset($event->participantId)){
                            $arrayTemp['participant_id'] = $event->participantId;
                        }
                        if(isset($event->assistingParticipantIds)){
                            foreach($event->assistingParticipantIds as $PNumber => $assistingParticipant){
                                $ref = 'assisting_participant_id_'.$num;
                                $arrayTest[$ref] = $assistingParticipant;
                                var_dump($arrayTest);
                                die();
                            }
                        }
                        if(isset($event->creatorId)){
                            $arrayTest['creator_id'] = $event->creatorId;
                        }
                        if(isset($event->position)){
                            $arrayTest['position_x'] = $event->position->x;
                        }
                        if(isset($event->position)){
                            $arrayTest['position_y'] = $event->position->y;
                        }
                        if(isset($event->itemId)){
                            $arrayTest['item_id'] = $event->itemId;
                        }
                        if(isset($event->killerId)){
                            $arrayTest['killer_id'] = $event->killerId;
                        }
                        if(isset($event->victimId)){
                            $arrayTest['victim_id'] = $event->victimId;
                        }
                        if(isset($event->laneType)){
                            $arrayTest['lane_type'] = $event->laneType;
                        }
                        if(isset($event->buildingType)){
                            $arrayTest['building_type'] = $event->buildingType;
                        }
                        if(isset($event->levelUpType)){
                            $arrayTest['level_up_type'] = $event->levelUpType;
                        }
                        if(isset($event->skillSlot)){
                            $arrayTest['skill_slot'] = $event->skillSlot;
                        }
                        if(isset($event->monsterType)){
                            $arrayTest['monster_type'] = $event->monsterType;
                        }
                        if(isset($event->teamId)){
                            $arrayTest['team_id'] = $event->teamId;
                        }
                        if(isset($event->wardType)){
                            $arrayTest['ward_type'] = $event->wardType;
                        }
                        if(isset($event->itemBefore)){
                            $arrayTest['item_before'] = $event->itemBefore;
                        }
                        if(isset($event->itemAfter)){
                            $arrayTest['item_after'] = $event->itemAfter;
                        }
                        if($count < 1){
                            DB::table('frame_events')->insert($arrayTemp);
                        }
                        else{
                            DB::table('frame_events')->where('id', $info->matchId . '-' . $eventId . '-' . $event->timestamp)->update($arrayTemp);
                        }
                    }
                }
            }  
        }
    }
}
