<?php 

namespace J0k3rrWild\EssentialsMate\Commands\Tasks\Spawn; 

use pocketmine\scheduler\Task;
use pocketmine\level\particle\FloatingTextParticle; 
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use J0k3rrWild\EssentialsMate\Commands\Spawn;
use J0k3rrWild\EssentialsMate\Main;
use pocketmine\utils\TextFormat as TF;
use pocketmine\level\Position;

class SpawnSchelud extends Task{



    public function __construct(Spawn $plugin, $player){ 
       $this->plugin = $plugin; 
       $this->player = $player; 
       
    } 


    public function onRun(int $tick){ 
        $sound = "pocketmine\level\sound\EndermanTeleportSound"; 
        
        $getX = $this->plugin->spawn->get("getX");
        $getY = $this->plugin->spawn->get("getY");
        $getZ = $this->plugin->spawn->get("getZ");
        $getWorld = $this->plugin->spawn->get("world");

        $tp = new Position($getX, $getY, $getZ, $this->plugin->plugin->getServer()->getLevelByName($getWorld));
        $this->player->teleport($tp);
        $this->player->getLevel()->addSound(new $sound($this->player));
        $this->player->sendMessage(TF::GREEN."[MeetMate] > Teleportowano na spawn");

      
     }
        

}