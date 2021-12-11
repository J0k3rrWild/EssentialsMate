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


class Adminfo extends PluginCommand implements CommandExecutor{

public $plugin;
public $vanish;
  
    public function __construct(Main $main) {
        $this->plugin = $main;
    }

    
         


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
      if($sender->hasPermission("essentials.adminfo") || $sender->hasPermission("essentials.admin")){
        if(!isset($args[0])) return false;
        if(!file_exists($this->plugin->getDataFolder()."players/". strtolower($args[0]) . "/player.yaml")){
           $sender->sendMessage(TF::RED."[MeetMate] > Gracz ".$args[0]." nie istnieje w bazie danych");
           return true;
        }
        $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($args[0]) . "/player.yaml", Config::YAML);
        
        $vanished = $this->plugin->vanished;

        $target = $this->plugin->getServer()->getPlayer($args[0]);
        $mutedStatus = $this->plugin->deco->get("muted");
        $privStatus = $this->plugin->deco->get("priv-disabled");
        $godStatus = $this->plugin->deco->get("godmode");
        $name = strtolower($args[0]);
        if($vanished === NULL){
            $vanished = array("nobodyishere7987897987987987");
        }


        if($target){
            $status = TF::GREEN."Online";
        }else{
            $status = TF::RED."Offline";
        }
        
        if($mutedStatus === false){
            $mutedStatus = TF::RED."False";
        }else{
            $mutedStatus = TF::GREEN."True";
        }
        
        if($privStatus === false){
            $privStatus = TF::GREEN."Włączone";
        }else{
            $privStatus = TF::RED."Wyłączone";
        }
        
        if($godStatus === false){
            $godStatus = TF::RED."Wyłączone";
        }else{
            $godStatus = TF::GREEN."Włączone";
        }
        $flyStatus = $this->plugin->deco->get("fly");
        if($flyStatus === false){
            $flyStatus = TF::RED."Wyłączone";
        }else{
            $flyStatus = TF::GREEN."Włączone";
        }
        foreach($vanished as $player){
        if((strtolower($name) === strtolower($player))){
            $this->vanish = TF::GREEN."Włączone";
            break;
        }else{
            $this->vanish = TF::RED."Wyłączone";
            
        }
        }

        $gamemodeStatus = $this->plugin->deco->get("gamemode");

        $sender->sendMessage(TF::GREEN."[MeetMate] > Informacje Administratorskie\n\n§2Muted: {$mutedStatus}\n§2Privs: {$privStatus}\n§2God: {$godStatus}\n§2Fly: {$flyStatus}\n§2Vanish: {$this->vanish}\n§2Gamemode: §6{$gamemodeStatus}\n§2Status: {$status}");

      }
    
    
      return true;
    }
    
}