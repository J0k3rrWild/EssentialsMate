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


class Unmute extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        $this->plugin = $main;
    }

    
         


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
       if(!isset($args[0])) return false;
       $player = $this->plugin->getServer()->getPlayer($args[0]);
       if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.mute")){
            if($player){
                $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($player->getPlayer()->getName()) . "/player.yaml", Config::YAML);
                $checkmute = $this->plugin->deco->get("muted");
                if($checkmute === true){
                    $this->plugin->deco->set("muted", false);
                    $this->plugin->deco->save();
                    // $this->plugin->cfg = $this->getDataFolder() . 'muted.json';
                    // $json = file_get_contents($this->cfg);
                    // $this->plugin->deco = json_decode($json, true);

                
                    
                    $sender->sendMessage(TF::GREEN."[MeetMate] > Gracz ".$player->getName()." został odmutowany");
                    $player->sendMessage(TF::GREEN."[MeetMate] > Zostałeś odmutowany");
                }else{
                    $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$player->getName()." nie jest zmutowany");
                    
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
