<?php 
 
declare(strict_types=1); 
 
namespace J0k3rrWild\EssentialsMate\Commands; 
 
 
use pocketmine\utils\TextFormat as TF; 
use pocketmine\command\Command; 
use pocketmine\command\CommandExecutor; 
use pocketmine\command\CommandSender; 
use pocketmine\command\PluginCommand; 
use pocketmine\level\Position; 
use pocketmine\Player; 
 
 
 
 
//Main 
use J0k3rrWild\EssentialsMate\Main; 
 
 
class Vanish extends PluginCommand implements CommandExecutor{ 
 
public $plugin; 
 
   
    public function __construct(Main $main) { 
        $this->plugin = $main; 
         
    } 
     
 
    public function hideJoin($player){ 
        $target = $this->plugin->getServer()->getPlayer($player); 
        if($target){
         foreach($this->plugin->getServer()->getOnlinePlayers() as $p){  
           
           $p->hidePlayer($target); 
         }  
          
        }
    } 
 
 
    public function hideThis(Player $player){ 
     foreach($this->plugin->getServer()->getOnlinePlayers() as $p){  
        
        $p->hidePlayer($player); 
           
     } 
    
    } 
 
    public function showThis(Player $player){ 
        foreach($this->plugin->getServer()->getOnlinePlayers() as $p){  
           
           $p->showPlayer($player); 
              
        } 
       
       } 
 
 
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool { 
                $sound = "pocketmine\level\sound\EndermanTeleportSound"; 
                $cfg = $this->plugin->getDataFolder() . 'vanished.json'; 
                $json = file_get_contents($cfg); 
                $this->plugin->vanished = json_decode($json, true); 
                
         
         
        if(!isset($args[0])){ 
            if($sender->hasPermission("essentials.vanish") || $sender->hasPermission("essentials.admin")){ 
                if ($sender->getName() === "CONSOLE"){ 
                    return false; 
                } 
 
             if(!in_array($sender->getName(), $this->plugin->vanished)){ 
 
                array_push($this->plugin->vanished, $sender->getName()); 
                file_put_contents($cfg, json_encode($this->plugin->vanished)); 
                $json = file_get_contents($cfg); 
                $this->plugin->vanished = json_decode($json, true); 
                $this->hideThis($sender); 
                $sender->getLevel()->addSound(new $sound($sender)); 
                $sender->sendMessage(TF::GREEN."[MeetMate] > Stałeś się niewidzialny dla innych graczy"); 
             
             }else{ 
                $sender->sendMessage(TF::RED."[MeetMate] > Jesteś już niewidzialny!"); 
             }  
            }else{ 
                $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy"); 
                return true; 
            } 
        } 
        if(isset($args[0])){ 
        //  if($sender->hasPermission("essentials.vanish.other") || $sender->hasPermission("essentials.admin")) 
        if($args[0] === "off"){ 
         if(!isset($args[1])){ 
          if($sender->hasPermission("essentials.vanish") || $sender->hasPermission("essentials.admin")){ 
           if(in_array($sender->getName(), $this->plugin->vanished)){  
             $this->showThis($sender); 
             $new = array_diff($this->plugin->vanished, array($sender->getName())); 
             file_put_contents($cfg, json_encode($new)); 
             $json = file_get_contents($cfg); 
             $this->plugin->vanished = json_decode($json, true);
             
             $sender->getLevel()->addSound(new $sound($sender)); 
              
             $sender->sendMessage(TF::GREEN."[MeetMate] > Stałeś się widzialny dla innych graczy"); 
           }else{ 
            $sender->sendMessage(TF::RED."[MeetMate] > Nie jesteś niewidzialny!"); 
           } 
          }else{ 
            $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy"); 
                return true; 
          } 
         }else{ 
            if($sender->hasPermission("essentials.vanish.other") || $sender->hasPermission("essentials.admin")){ 
              $target = $this->plugin->getServer()->getPlayer($args[1]); 
              if($target){ 
                if(in_array($target->getName(), $this->plugin->vanished)){  
                    $this->showThis($target); 
                    $new = array_diff($this->plugin->vanished, array($target->getName())); 
                    file_put_contents($cfg, json_encode($new)); 
                    $json = file_get_contents($cfg); 
                    $this->plugin->vanished = json_decode($json, true); 
                    $target->getLevel()->addSound(new $sound($target)); 
                    $target->sendMessage(TF::GREEN."[MeetMate] > Stałeś się widzialny dla innych graczy"); 
                    $sender->sendMessage(TF::GREEN."[MeetMate] > Gracz ".$args[1]." stał się widzialny"); 
                }else{ 
                $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[1]." jest już widzialny!"); 
                } 
              }else{ 
                $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[1]." jest offline bądz niepoprawny nick");  
              } 
            }else{ 
                $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy"); 
                return true; 
            } 
        } 
        }else{ 
         if($args[0] !== "off"){ 
           if($sender->hasPermission("essentials.vanish.other") || $sender->hasPermission("essentials.admin")){   
            $target = $this->plugin->getServer()->getPlayer($args[0]); 
            if($target){
              if(!in_array($target->getName(), $this->plugin->vanished)){ 
                  $this->hideThis($target); 
                  array_push($this->plugin->vanished, $target->getName()); 
                  file_put_contents($cfg, json_encode($this->plugin->vanished)); 
                  $json = file_get_contents($cfg); 
                  $this->plugin->vanished = json_decode($json, true); 
                  $this->hideThis($target); 
                  $target->getLevel()->addSound(new $sound($target)); 
                  $target->sendMessage(TF::GREEN."[MeetMate] > Stałeś się niewidzialny dla innych graczy");   
                  $sender->sendMessage(TF::GREEN."[MeetMate] > Gracz ".$args[0]." stał się niewidzialny");   
              }else{ 
                  $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[0]." jest już niewidzialny!"); 
              } 
            }else{
              $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[0]." jest offline bądz niepoprawny nick");
            }
           }else{ 
            $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy"); 
            return true; 
           }   
         } 
        } 
         
      
    } 
  return true; 
 } 
}