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
use pocketmine\utils\Config;
 
 
 
 
//Main 
use J0k3rrWild\EssentialsMate\Main; 
 
 
class God extends PluginCommand implements CommandExecutor{ 
 
public $plugin; 
 
   
    public function __construct(Main $main) { 
        $this->plugin = $main; 
         
    } 
    


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool { 
    
       
     if(!isset($args[0])){
      if($sender->hasPermission("essentials.god") || $sender->hasPermission("essentials.admin")){
        $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($sender->getPlayer()->getName()) . "/player.yaml", Config::YAML);
        if($this->plugin->deco->get("godmode") === false){
         $this->plugin->deco->set("godmode", true);
         $this->plugin->deco->save();
         $sender->getPlayer()->setHealth($sender->getMaxHealth());
         $sender->getPlayer()->setFood(20);
         $sender->getPlayer()->setSaturation(20);
         $sender->sendMessage(TF::GREEN." [MeetMate] > Stałeś się całkowicie nieśmiertelny");
        }else{
            $sender->sendMessage(TF::RED." [MeetMate] > Już jesteś nieśmiertelny");
        }
      }else{
        $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy"); 
            return true;
    }
    
    
    
    }
     if(isset($args[0])){
       if($args[0] === "off" && !isset($args[1])){
        if($sender->hasPermission("essentials.god") || $sender->hasPermission("essentials.admin")){
            
                if($this->plugin->deco->get("godmode") === true){
                    $this->plugin->deco->set("godmode", false);
                    $this->plugin->deco->save();
                    $sender->sendMessage(TF::GREEN." [MeetMate] > Stałeś się znów śmiertelny");
                }else{
                    $sender->sendMessage(TF::RED." [MeetMate] > Już jesteś śmiertelny");
                }
            
        }else{
            $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy"); 
            return true;
            }
        }
        if(isset($args[0])){
          if($sender->hasPermission("essentials.god.other") || $sender->hasPermission("essentials.admin")){
           if($args[0] === "off" && isset($args[1])){
            $target = $this->plugin->getServer()->getPlayer($args[1]);
            if($target){
                if($this->plugin->deco->get("godmode") === true){
                    $this->plugin->deco->set("godmode", false);
                    $this->plugin->deco->save();
                    $sender->sendMessage(TF::GREEN." [MeetMate] > Gracz ".$args[1]." stał się znów śmiertelny");
                    $target->sendMessage(TF::GREEN." [MeetMate] > Stałeś się znów śmiertelny");
                }else{
                    $sender->sendMessage(TF::RED." [MeetMate] > Gracz ".$args[1]." już jest śmiertelny");
                }
            }else{
                $sender->sendMessage(TF::RED." [MeetMate] > Gracza nie ma na serwerze lub nick jest niepoprawny");  
            }
           }else{
            if($args[0] !== "off"){
            $target = $this->plugin->getServer()->getPlayer($args[0]);
                if($target){
                    if($this->plugin->deco->get("godmode") === false){
                        $this->plugin->deco->set("godmode", true);
                        $this->plugin->deco->save();
                        $target->getPlayer()->setHealth($target->getMaxHealth());
                        $target->setFood(20);
                        $target->setSaturation(20);
                        $sender->sendMessage(TF::GREEN." [MeetMate] > Gracz ".$args[0]." stał się nieśmiertelny");
                        $target->sendMessage(TF::GREEN." [MeetMate] > Stałeś się nieśmiertelny");
                    }else{
                        $sender->sendMessage(TF::RED." [MeetMate] > Gracz ".$args[0]." już jest nieśmiertelny");
                    }
                }else{
                    $sender->sendMessage(TF::RED." [MeetMate] > Gracza nie ma na serwerze lub nick jest niepoprawny");  
                }
            }
           }   
          }else{
            $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy"); 
            return true;
          }
        }
     }
    return true;
    }


}