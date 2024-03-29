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
    protected $signature = 'updateSummoner {id} {option} {num?}';

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
    //option settings
    //option = 1 Soft Update
    //option = 2 Medium Update
    //option = 3 Hard Update
    $arguments = $this->argument();
    $id = $arguments['id'];
    $option = $arguments['option'];
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
      $count = DB::table('games')->where('id', $game->matchId)->count();
      if($count == 0){
        DB::table('games')->insert(array('id' => $game->matchId));
      }
      $count = DB::table('summoner_games')->where('game_id', $game->matchId)->count();
      if($count < 1){
        DB::table('summoner_games')->insert(array('id' => $id . "-" . $game->matchId, 'summoner_id' => $id, 'champion_id' => $game->champion, 'role' => $game->role, 'lane' => $game->lane, 'timestamp' => $game->timestamp, 'queue' => $game->queue, 'season' => $game->season, 'game_id' => $game->matchId));
      }
      else{
        DB::table('summoner_games')->where('id', $id . '-' . $game->matchId)->update(array('id' => $id . "-" . $game->matchId, 'summoner_id' => $id, 'champion_id' => $game->champion, 'role' => $game->role, 'lane' => $game->lane, 'timestamp' => $game->timestamp, 'queue' => $game->queue, 'season' => $game->season, 'game_id' => $game->matchId));
      }
    }
    //herehere
    $games = new stdClass();
    if($option == 1){
      return;
    }
    elseif($option == 2){
      if(isset($arguments['num'])){
        $games = DB::table('summoner_games')->where('summoner_id', $id)->orderBy('game_id', 'desc')->limit($arguments['num'])->get();//Get All Games...
        $this->updateGames($games);
      }
      else{
        $games = DB::table('summoner_games')->where('summoner_id', $id)->whereNull('winner')->orderBy('game_id', 'desc')->get();
        $this->updateGames($games);
      }
    }
    elseif($option == 3){
      if(isset($arguments['num'])){
        $games = DB::table('summoner_games')->where('summoner_id', $id)->orderBy('game_id', 'desc')->limit($arguments['num'])->get();//Get All Games...
        $this->updateGames($games);
      }
      else{
        $games = DB::table('summoner_games')->where('summoner_id', $id)->orderBy('game_id', 'desc')->get();//Get All Games...
        $this->updateGames($games);
      }
    }
  }



  public function updateGames($games){
    foreach($games as $game){   //Go By Game
      $info = API_Match($game->game_id);
      if(is_int($info)){
        sleep(3);
        continue;
      }
      $counter = DB::table('games')->where('id', $info->matchId)->count();
      $option = -1;
      $t1_kills = 0;
      $t2_kills = 0;
      if($info->teams[0]->teamId == 100){
        $option = 1;
      }
      foreach($info->participants as $participantInfo){
        if ($participantInfo->teamId == 100){
          $t1_kills += $participantInfo->stats->kills;
        }
        else{
          $t2_kills += $participantInfo->stats->kills;
        }
      }
      if($counter == 0){
        if($option == 1){
          DB::table('games')->insert(array(
                          'id' => $info->matchId,
                          'queue' => $info->queueType,
                          'match_duration' => $info->matchDuration,
                          'season' => $info->season,
                          'timestamp' => $info->matchCreation,
                          't1_dragons' => $info->teams[0]->dragonKills,
                          't2_dragons' => $info->teams[1]->dragonKills,
                          't1_barons' => $info->teams[0]->baronKills,
                          't2_barons' => $info->teams[1]->baronKills,
                          't1_heralds' => $info->teams[0]->riftHeraldKills,
                          't2_heralds' => $info->teams[1]->riftHeraldKills,
                          't1_kills' => $t1_kills,
                          't2_kills' => $t2_kills ));
        }
        else{
          DB::table('games')->insert(array(
                          'id' => $info->matchId,
                          'queue' => $info->queueType,
                          'match_duration' => $info->matchDuration,
                          'season' => $info->season,
                          'timestamp' => $info->matchCreation,
                          't1_dragons' => $info->teams[1]->dragonKills,
                          't2_dragons' => $info->teams[0]->dragonKills,
                          't1_barons' => $info->teams[1]->baronKills,
                          't2_barons' => $info->teams[0]->baronKills,
                          't1_heralds' => $info->teams[1]->riftHeraldKills,
                          't2_heralds' => $info->teams[0]->riftHeraldKills,
                          't1_kills' => $t1_kills,
                          't2_kills' => $t2_kills ));
      }
    }
    else{
      if($option == 1){
        DB::table('games')->where('id', $info->matchId)->update(array(
                          'queue' => $info->queueType,
                          'match_duration' => $info->matchDuration,
                          'season' => $info->season,
                          'timestamp' => $info->matchCreation,
                          't1_dragons' => $info->teams[0]->dragonKills,
                          't2_dragons' => $info->teams[1]->dragonKills,
                          't1_barons' => $info->teams[0]->baronKills,
                          't2_barons' => $info->teams[1]->baronKills,
                          't1_heralds' => $info->teams[0]->riftHeraldKills,
                          't2_heralds' => $info->teams[1]->riftHeraldKills,
                          't1_kills' => $t1_kills,
                          't2_kills' => $t2_kills ));
      }
      else{
        DB::table('games')->where('id', $info->matchId)->update(array(
                          'queue' => $info->queueType,
                          'match_duration' => $info->matchDuration,
                          'season' => $info->season,
                          'timestamp' => $info->matchCreation,
                          't1_dragons' => $info->teams[1]->dragonKills,
                          't2_dragons' => $info->teams[0]->dragonKills,
                          't1_barons' => $info->teams[1]->baronKills,
                          't2_barons' => $info->teams[0]->baronKills,
                          't1_heralds' => $info->teams[1]->riftHeraldKills,
                          't2_heralds' => $info->teams[0]->riftHeraldKills,
                          't1_kills' => $t1_kills,
                          't2_kills' => $t2_kills ));
      }
    }
    //print "Updated Games\n";
    foreach($info->participantIdentities as $participantIdentity){ //Go By Participant
      foreach($info->participants as $participant){
        if($participantIdentity->participantId == $participant->participantId){
          $count = DB::table('summoner_games')->where('game_id', $game->game_id)->where('summoner_id', $participantIdentity->player->summonerId)->count();
          $arrayTemp = array(
            'id' => $participantIdentity->player->summonerId . "-" . $info->matchId ,
            'summoner_id' => $participantIdentity->player->summonerId,
            'champion_id' => $participant->championId,
            'queue' =>  $info->queueType,
            'season' =>  $info->season,
            'game_id' => $info->matchId,
            'team_id' => $participant->teamId,
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
            'assists' => $participant->stats->assists,
            'total_damage_taken' => $participant->stats->totalDamageTaken,
            'magic_damage_taken' => $participant->stats->magicDamageTaken,
            'physical_damage_taken' => $participant->stats->physicalDamageTaken,
            'true_damage_taken' => $participant->stats->trueDamageTaken,
            'wards_placed' => $participant->stats->wardsPlaced,
            'wards_killed' => $participant->stats->wardsKilled,
            'gold_earned' => $participant->stats->goldEarned,
            'minions_killed' => $participant->stats->minionsKilled,
            'participant_id' => $participant->participantId,
            'winner' => $participant->stats->winner);
        if(isset($participant->timeline)){
          $arrayTemp['lane'] =  $participant->timeline->lane;
          $arrayTemp['role'] =  $participant->timeline->role;
        }
        if($count < 1){
          DB::table('summoner_games')->insert($arrayTemp);
        }
        else{
          DB::table('summoner_games')->where('id', $participantIdentity->player->summonerId . "-" . $info->matchId)->update($arrayTemp);
        }
      }
    }
  }
  //print "Updated Summoner Games\n";
  //herenow
  if(isset($info->timeline)){
    foreach($info->timeline->frames as $frameId => $frame){
      $count = DB::table('frames')->where('game_id', $info->matchId)->where('frame_id', $frameId)->count();
      $arrayTemp = array(
        'game_id' => $info->matchId,
        'frame_id' => $frameId);
      if($count < 1){
        DB::table('frames')->insert($arrayTemp);
      }
      else{
        DB::table('frames')->where('game_id', $info->matchId)->where('frame_id', $frameId)->update($arrayTemp);
      }
      //print "Updated Frames\n";
      foreach($frame->participantFrames as $pFrame){
        $count = DB::table('participants_frames')->where('game_id', $info->matchId)->where('participant_id', $pFrame->participantId)->where('timestamp', $frame->timestamp)->count();
        $arrayTemp = array(
          'game_id' => $info->matchId,
          'participant_id' => $pFrame->participantId,
          'timestamp' => $frame->timestamp,
          'current_gold' => $pFrame->currentGold,
          'total_gold' => $pFrame->totalGold,
          'minions_killed' => $pFrame->minionsKilled,
          'level' => $pFrame->level,
          'xp' => $pFrame->xp);
        if($count < 1)
          DB::table('participants_frames')->insert($arrayTemp);
        else
          DB::table('participants_frames')->where('game_id', $info->matchId)->where('participant_id', $pFrame->participantId)->where('timestamp', $frame->timestamp)->update($arrayTemp);
      }
      //print "Updated Participants Frames\n";
      if(isset($frame->events)){
        foreach($frame->events as $eventId => $event){
          $count = DB::table('events')->where('game_id', $info->matchId)->where('event_id', $eventId)->where('timestamp', $event->timestamp)->count();
          $arrayTemp = array(
            'game_id' => $info->matchId,
            'event_type' => $event->eventType,
            'timestamp' => $event->timestamp,
            'event_id' => $eventId);
          if(isset($event->participantId)){
            $arrayTemp['participant_id'] = $event->participantId;
          }
          if(isset($event->assistingParticipantIds)){
            foreach($event->assistingParticipantIds as $PNumber => $assistingParticipant){
              $num = $PNumber + 1;
              $ref = 'assisting_participant_id_'.$num;
              $arrayTemp[$ref] = $assistingParticipant;
            }
          }
          if(isset($event->creatorId)){
            $arrayTemp['creator_id'] = $event->creatorId;
            $arrayTemp['participant_id'] = $event->creatorId;
          }
          if(isset($event->position)){
            $arrayTemp['position_x'] = $event->position->x;
          }
          if(isset($event->position)){
            $arrayTemp['position_y'] = $event->position->y;
          }
          if(isset($event->itemId)){
            $arrayTemp['item_id'] = $event->itemId;
          }
          if(isset($event->killerId)){
            $arrayTemp['killer_id'] = $event->killerId;
            $arrayTemp['participant_id'] = $event->killerId;
          }
          if(isset($event->victimId)){
            $arrayTemp['victim_id'] = $event->victimId;
          }
          if(isset($event->laneType)){
            $arrayTemp['lane_type'] = $event->laneType;
          }
          if(isset($event->buildingType)){
            $arrayTemp['building_type'] = $event->buildingType;
          }
          if(isset($event->levelUpType)){
            $arrayTemp['level_up_type'] = $event->levelUpType;
          }
          if(isset($event->skillSlot)){
            $arrayTemp['skill_slot'] = $event->skillSlot;
          }
          if(isset($event->monsterType)){
            $arrayTemp['monster_type'] = $event->monsterType;
          }
          if(isset($event->teamId)){
            $arrayTemp['team_id'] = $event->teamId;
          }
          if(isset($event->wardType)){
            $arrayTemp['ward_type'] = $event->wardType;
          }
          if(isset($event->itemBefore)){
            $arrayTemp['item_before'] = $event->itemBefore;
          }
          if(isset($event->itemAfter)){
            $arrayTemp['item_after'] = $event->itemAfter;
          }
          if($count < 1){
            DB::table('events')->insert($arrayTemp);
          }
          else{
            DB::table('events')->where('game_id', $info->matchId)->where('event_id', $eventId)->where('timestamp', $event->timestamp)->update($arrayTemp);
          }
        }
        //Print "Updated Events\n";
      }
    }
  }
  }
  }
}
