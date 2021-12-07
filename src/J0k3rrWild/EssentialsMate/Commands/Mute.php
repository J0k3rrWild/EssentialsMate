<?php

declare(strict_types=1);

namespace J0k3rrWild\EssentialsMate\Commands;


use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\Config;



//Main
use J0k3rrWild\EssentialsMate\Main;


class Mute extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        $this->plugin = $main;
    }

    
         


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        if(!isset($args[0])) return false;
        
        if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.mute")){
             if($player = $this->plugin->getServer()->getPlayer($args[0])){
                  if($sender !== $player){
                    if($player->hasPermission("essentials.mute.bypass") || $player->hasPermission("essentials.admin")){
                      $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$player->getName()." nie może zostać zmutowany!");
                      return true;
                    }
                     $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($player->getPlayer()->getName()) . "/player.yaml", Config::YAML);
                     $checkmute = $this->plugin->deco->get("muted");
                     if($checkmute === false){
                        $this->plugin->deco->set("muted", true);
                        $this->plugin->deco->save();
                        // $this->plugin->cfg = $this->getDataFolder() . 'muted.json';
                        // $json = file_get_contents($this->cfg);
                        // $this->plugin->deco = json_decode($json, true);

                    
                        
                        $sender->sendMessage(TF::GREEN."[MeetMate] > Gracz ".$player->getName()." zmutowany");
                        $player->sendMessage(TF::RED."[MeetMate] > Zostałeś zmutowany");
                     }else{
                        $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$player->getName()." już jest zmutowany");
                        
                    }
                  }else{
                    $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz zmutować samego siebie!");
                  }
             }else{
               $sender->sendMessage(TF::RED."[MeetMate] > Niepoprawny nick lub gracz jest offline!");
             }
        }else{
            $sender->sendMessage(TF::RED."[MeetMate] > Nie masz uprawnień by używać tej komendy!");
        }
            
        return true;
    }


}
