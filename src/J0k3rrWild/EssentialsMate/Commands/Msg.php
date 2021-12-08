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


class Msg extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        parent::__construct("tell", $main, [ "msg", "w"]);
        $this->setUsage("/tell <player> <tresc>");
        $this->plugin = $main;
    }

    
         


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        if(!isset($args[0])) return false;

        $player = $this->plugin->getServer()->getPlayer($args[0]);
       if($sender->hasPermission("essentials.msg")){
        $cmdd = strtolower($args[0]);
        if ($cmdd === "off" && !isset($args[1])|| $cmdd === "on" && !isset($args[1])){
            $cmdd = false;
        }else{
            $cmdd = true;
        }
          
       switch($cmdd){
        case true:    
           if($player){
            if($sender !== $player){
            
            $player->sendMessage(TF::GOLD."[{$sender->getName()} -> {$player->getName()}] > {$args[1]}");
            $sender->sendMessage(TF::GOLD."[{$sender->getName()} -> {$player->getName()}] > {$args[1]}");
            }else{
                $sender->sendMessage(TF::RED. "[MeetMate] > Nie możesz wysyłać wiadomości do samego siebie!");
            }
                
           }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Nie wykryto gracza ".$args[0]." na serwerze");
            }
            break;
        case false:
           if($args[0] === "off"){ 
            $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($sender->getPlayer()->getName()) . "/player.yaml", Config::YAML);
            $checkmsg = $this->plugin->deco->get("priv-disabled");
            if($checkmsg === false){
                $this->plugin->deco->set("priv-disabled", true);
                $this->plugin->deco->save();
                $sender->sendMessage(TF::GREEN."[MeetMate] > Pomyślnie wyłączyłeś prywatne wiadomości (nie dotyczy od administracji)");
            }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Prywatne wiadomosci juz są wyłączone!");
            }
           }else{
            $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($sender->getPlayer()->getName()) . "/player.yaml", Config::YAML);
            $checkmsg = $this->plugin->deco->get("priv-disabled");
            if($checkmsg === true){
                $this->plugin->deco->set("priv-disabled", false);
                $this->plugin->deco->save();
                $sender->sendMessage(TF::GREEN."[MeetMate] > Pomyślnie włączyłeś prywatne wiadomości");
            }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Prywatne wiadomosci juz są włączone!");
            }
           }
           break; 
       }
    }
        return true;
    }
        
}



