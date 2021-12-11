<?php

declare(strict_types=1);

namespace J0k3rrWild\EssentialsMate\Commands;


use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\Config;
use pocketmine\Player;


//Main
use J0k3rrWild\EssentialsMate\Main;


class Gamemode extends PluginCommand implements CommandExecutor{

public $plugin;
public $gm = array("0", "survival", "1", "creative", "2", "spectator");
  
    public function __construct(Main $main) {
        parent::__construct("gamemode", $main, ["gm","gmc","gma","gms"]);
        $this->setUsage("/gamemode <tryb> <gracz>*");
        $this->setDescription("Zmienia gamemode");
        $this->plugin = $main;
    }

    
         


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
    if(($cmd->getName() === "gm") || ($cmd->getName() === "gamemode")){ 
     if(!isset($args[0])) return false;
      if(!in_array($args[0], $this->gm)){
        $sender->sendMessage(TF::RED."[MeetMate] > Nie wykryto gamemode ".$args[0]."");
        return true;
       }
       if(isset($args[0]) || !isset($args[1])){
        if(!($sender instanceof Player) && !isset($args[1])){
         $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz zmienić swojego gamemode w konsoli!");
         return true;
        }
       }
     }
    if(($cmd->getName() === "gmc" || $cmd->getName() === "gma" || $cmd->getName() === "gms") && !isset($args[0])){
        if(!($sender instanceof Player) && !isset($args[1])){
            $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz zmienić swojego gamemode w konsoli!");
            return true;
           }
      }


    
    // -----------------------------------[SURVIVAL]-----------------------------------------------------------------
    if(($cmd->getName() === "gma") && !isset($args[0])){
      if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode")){
          $sender->setGamemode(Player::SURVIVAL);
          $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś swój gamemode na: survival");

          $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($sender->getPlayer()->getName()) . "/player.yaml", Config::YAML);
          $this->plugin->deco->set("gamemode", "survival");
          $this->plugin->deco->save();
         foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
          if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
            if($sender !== $p){
            $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: survival]");
            }
           }
        }
        $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: survival]");
     }
    }
    if(($cmd->getName() === "gma") && isset($args[0])){
      if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode.other")){
        $target = $this->plugin->getServer()->getPlayer($args[0]);
       if($target){ 
        $target->setGamemode(Player::SURVIVAL);
        $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś gamemode gracza ".$args[0]." na: survival");
        $target->sendMessage(TF::GREEN."[MeetMate] > Zmieniono twój gamemode na: survival");
        $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($target->getPlayer()->getName()) . "/player.yaml", Config::YAML);
        $this->plugin->deco->set("gamemode", "survival");
        $this->plugin->deco->save();
        foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
            if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
              if($sender !== $p){
              $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[0]." na: survival]");
              }
            }
          }
          $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[0]." na: survival]");
        }else{
          $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[0]." jest offline");
        }
      }

  }  

    if(($cmd->getName() === "gamemode") && ($args[0] === "survival" || $args[0] === "0")){
      if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode")){
          $sender->setGamemode(Player::SURVIVAL);
          $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś swój gamemode na: survival");
          $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($sender->getPlayer()->getName()) . "/player.yaml", Config::YAML);
          $this->plugin->deco->set("gamemode", "survival");
          $this->plugin->deco->save();
          foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
            if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
              if($sender !== $p){
              $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: survival]");
              }
             }
          }
          $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: survival]");
      }

    }

    if(($cmd->getName() === "gamemode") && ($args[0] === "survival" || $args[0] === "0")){
      if(isset($args[1])){  
       if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode.other")){
         $target = $this->plugin->getServer()->getPlayer($args[1]);
        if($target){
         $target->setGamemode(Player::SURVIVAL);
         $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś gamemode gracza ".$args[1]." na: survival");
         $target->sendMessage(TF::GREEN."[MeetMate] > Zmieniono twój gamemode na: survival");
         $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($target->getPlayer()->getName()) . "/player.yaml", Config::YAML);
          $this->plugin->deco->set("gamemode", "survival");
          $this->plugin->deco->save();
          
           foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
             if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
               if($sender !== $p){
                 $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[1]." na: survival]");
               }
              }
           }
           $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[1]." na: survival]");
         }else{
           $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[1]." jest offline");
         }
       }
      }
     }
    // -----------------------------------[CREATIVE]-----------------------------------------------------------------
    
    if(($cmd->getName() === "gmc") && !isset($args[0])){
      if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode")){
          $sender->setGamemode(Player::CREATIVE);
          $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś swój gamemode na: creative");
          $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($sender->getPlayer()->getName()) . "/player.yaml", Config::YAML);
          $this->plugin->deco->set("gamemode", "creative");
          $this->plugin->deco->save();
          foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
            if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
              if($sender !== $p){
              $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: creative]");
              }
             }
          }
          $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: creative]");
      }
    }
    if(($cmd->getName() === "gmc") && isset($args[0])){
      if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode.other")){
        $target = $this->plugin->getServer()->getPlayer($args[0]);
       if($target){ 
        $target->setGamemode(Player::CREATIVE);
        $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś gamemode gracza ".$args[0]." na: creative");
        $target->sendMessage(TF::GREEN."[MeetMate] > Zmieniono twój gamemode na: creative");
        $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($target->getPlayer()->getName()) . "/player.yaml", Config::YAML);
        $this->plugin->deco->set("gamemode", "creative");
        $this->plugin->deco->save();
        foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
            if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
              if($sender !== $p){
              $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[0]." na: creative]");
              }
            }
          }
          $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[0]." na: creative]");
        }else{
          $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[0]." jest offline");
        }
      }

  }  

    if(($cmd->getName() === "gamemode") && ($args[0] === "creative" || $args[0] === "1")){
      if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode")){
          $sender->setGamemode(Player::CREATIVE);
          $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś swój gamemode na: creative");
          $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($sender->getPlayer()->getName()) . "/player.yaml", Config::YAML);
          $this->plugin->deco->set("gamemode", "creative");
          $this->plugin->deco->save();
          foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
            if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
              if($sender !== $p){
              $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: creative]");
              }
             }
          }
          $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: creative]");
      }

    }

    if(($cmd->getName() === "gamemode") && ($args[0] === "creative" || $args[0] === "1")){
      if(isset($args[1])){  
       if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode.other")){
         $target = $this->plugin->getServer()->getPlayer($args[1]);
        if($target){
         $target->setGamemode(Player::CREATIVE);
         $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś gamemode gracza ".$args[1]." na: creative");
         $target->sendMessage(TF::GREEN."[MeetMate] > Zmieniono twój gamemode na: creative");
         $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($target->getPlayer()->getName()) . "/player.yaml", Config::YAML);
         $this->plugin->deco->set("gamemode", "creative");
         $this->plugin->deco->save();
           foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
             if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
               if($sender !== $p){
                 $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[1]." na: creative]");
               }
              }
           }
           $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[1]." na: creative]");
         }else{
           $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[1]." jest offline");
         }
       }
      }
     }

    // -----------------------------------[SPECTATOR]-----------------------------------------------------------------
    if(($cmd->getName() === "gms") && !isset($args[0])){
      if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode")){
        $sender->setGamemode(Player::SPECTATOR);
        $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś swój gamemode na: spectator");
        $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($sender->getPlayer()->getName()) . "/player.yaml", Config::YAML);
        $this->plugin->deco->set("gamemode", "spectator");
        $this->plugin->deco->save();
        foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
            if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
              if($sender !== $p){
              $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: spectator]");
              }
             }
          }
          $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: spectator]");
     }

   }

    if(($cmd->getName() === "gms") && isset($args[0])){
        if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode.other")){
          $target = $this->plugin->getServer()->getPlayer($args[0]);
         if($target){ 
          $target->setGamemode(Player::SPECTATOR);
          $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś gamemode gracza ".$args[0]." na: spectator");
          $target->sendMessage(TF::GREEN."[MeetMate] > Zmieniono twój gamemode na: spectator");
          $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($target->getPlayer()->getName()) . "/player.yaml", Config::YAML);
          $this->plugin->deco->set("gamemode", "spectator");
          $this->plugin->deco->save();
          foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
              if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
                if($sender !== $p){
                $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[0]." na: spectator]");
                }
              }
            }
            $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[0]." na: spectator]");
          }else{
            $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[0]." jest offline");
          }
        }

    }


    if(($cmd->getName() === "gamemode") && ($args[0] === "spectator" || $args[0] === "2")){
     if(!isset($args[1])){ 
      if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode")){
          $sender->setGamemode(Player::SPECTATOR);
          $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś swój gamemode na: spectator");
          $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($sender->getPlayer()->getName()) . "/player.yaml", Config::YAML);
          $this->plugin->deco->set("gamemode", "spectator");
          $this->plugin->deco->save();
          foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
            if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
              if($sender !== $p){
              $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: spectator]");
              }
             }
          }
          $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode na: spectator]");
      }
     }
    }
    if(($cmd->getName() === "gamemode") && ($args[0] === "spectator" || $args[0] === "2")){
     if(isset($args[1])){  
      if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.gamemode.other")){
        $target = $this->plugin->getServer()->getPlayer($args[1]);
       if($target){
        $target->setGamemode(Player::SPECTATOR);
        $sender->sendMessage(TF::GREEN."[MeetMate] > Zmieniłeś gamemode gracza ".$args[1]." na: spectator");
        $target->sendMessage(TF::GREEN."[MeetMate] > Zmieniono twój gamemode na: spectator");
        $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($target->getPlayer()->getName()) . "/player.yaml", Config::YAML);
        $this->plugin->deco->set("gamemode", "spectator");
        $this->plugin->deco->save();
          foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
            if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
              if($sender !== $p){
                $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[1]." na: spectator]");
              }
             }
          }
          $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zmiana gamemode gracza ".$args[1]." na: spectator]");
        }else{
          $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[1]." jest offline");
        }
      }
     }
    }

    return true;
    }
}