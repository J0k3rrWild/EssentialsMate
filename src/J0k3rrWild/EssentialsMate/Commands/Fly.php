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
 
 
class Fly extends PluginCommand implements CommandExecutor{ 
 
public $plugin; 
 
   
    public function __construct(Main $main) { 
        $this->plugin = $main; 
         
    } 
    


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool { 
    
       
     if(!isset($args[0])){
      if($sender->hasPermission("essentials.fly") || $sender->hasPermission("essentials.admin")){
        $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($sender->getPlayer()->getName()) . "/player.yaml", Config::YAML);
        if($this->plugin->deco->get("fly") === false){
         $this->plugin->deco->set("fly", true);
         $this->plugin->deco->save();
         $sender->setFlying(true);
         $sender->setAllowFlight(true);

         //fly script

         $sender->sendMessage(TF::GREEN."[MeetMate] > Aktywowano umiejętność latania");
        }else{
            $sender->sendMessage(TF::RED."[MeetMate] > Już masz aktywowaną umiejętność latania!");
        }
      }else{
        $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy"); 
            return true;
    }
    
    
    
    }
     if(isset($args[0])){
       if($args[0] === "off" && !isset($args[1])){
        if($sender->hasPermission("essentials.fly") || $sender->hasPermission("essentials.admin")){
            
                if($this->plugin->deco->get("fly") === true){
                    $this->plugin->deco->set("fly", false);
                    $this->plugin->deco->save();
                    $sender->setFlying(false);
                    $sender->setAllowFlight(false);
                    $sender->sendMessage(TF::GREEN."[MeetMate] > Dektywowano umiejętność latania");
                }else{
                    $sender->sendMessage(TF::RED."[MeetMate] > Nie masz aktywowanej umiejętności latania!");
                }
            
        }else{
            $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy"); 
            return true;
            }
        }
        if(isset($args[0])){
          if($sender->hasPermission("essentials.fly.other") || $sender->hasPermission("essentials.admin")){
           if($args[0] === "off" && isset($args[1])){
            $target = $this->plugin->getServer()->getPlayer($args[1]);
            if($target){
                if($this->plugin->deco->get("fly") === true){
                    $this->plugin->deco->set("fly", false);
                    $this->plugin->deco->save();
                    $target->setFlying(false);
                    $target->setAllowFlight(false);
                    $sender->sendMessage(TF::GREEN."[MeetMate] > Umięjętność latania dla gracza ".$args[1]." została dezaktywowana");
                    $target->sendMessage(TF::GREEN."[MeetMate] > Dektywowano umiejętność latania");
                }else{
                    $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[1]." już ma dezaktywowaną umiejętność latania");
                }
            }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Gracza nie ma na serwerze lub nick jest niepoprawny");  
            }
           }else{
            if($args[0] !== "off"){
            $target = $this->plugin->getServer()->getPlayer($args[0]);
                if($target){
                    if($this->plugin->deco->get("fly") === false){
                        $this->plugin->deco->set("fly", true);
                        $this->plugin->deco->save();
                        $target->setFlying(true);
                        $target->setAllowFlight(true);

                        $sender->sendMessage(TF::GREEN."[MeetMate] > Umięjętność latania dla gracza ".$args[0]." została aktywowana");
                        $target->sendMessage(TF::GREEN."[MeetMate] > Aktywowano umiejętność latania");
                    }else{
                        $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[0]." już ma aktywowaną umiejętność latania");
                    }
                }else{
                    $sender->sendMessage(TF::RED."[MeetMate] > Gracza nie ma na serwerze lub nick jest niepoprawny");  
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