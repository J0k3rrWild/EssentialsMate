<?php 

namespace J0k3rrWild\EssentialsMate\Commands\Tasks\Stop; 

use pocketmine\scheduler\Task;
use pocketmine\level\particle\FloatingTextParticle; 
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use J0k3rrWild\EssentialsMate\Commands\Stop;
use J0k3rrWild\EssentialsMate\Main;
use pocketmine\utils\TextFormat as TF;


class StopSchelud extends Task{
public $clock = array("5", "4", "3", "2", "1", "0");

public $reason;
public $i = 6;


    public function __construct(Stop $plugin, $reason){ 
       $this->plugin = $plugin; 
       
       $this->reason = $reason; 
       
    } 


    public function onRun(int $tick){ 
      $players =  $this->plugin->plugin->getServer()->getOnlinePlayers();
       
      
      foreach($this->clock as $sec){
       $this->i--;
        if($this->i === 0){
         foreach($players as $p){
          if(isset($this->reason)){
            $p->kick(TF::RED."[MeetMate] > Serwer został wyłączony. Powód: {$this->reason}", false);
          }else{
            $p->kick(TF::RED."[MeetMate] > Serwer został wyłączony.", false);
          }
         }
          $this->plugin->plugin->getServer()->shutdown();
        }
        $this->plugin->plugin->getServer()->broadcastMessage(TF::RED."[MeetMate] > Server zostanie zrestarotwany za {$this->i} sekund"); 
        return true;
      }

      
     }
        

}