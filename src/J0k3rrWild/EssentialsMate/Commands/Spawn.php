<?php

declare(strict_types=1);

namespace J0k3rrWild\EssentialsMate\Commands;


use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\level\Position;



//Main
use J0k3rrWild\EssentialsMate\Main;


class Spawn extends PluginCommand implements CommandExecutor{

public $plugin;
public $spawn;
  
    public function __construct(Main $main) {
        $this->plugin = $main;
    }

    
         




    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        $sound = "pocketmine\level\sound\EndermanTeleportSound"; 
        $this->spawn = new Config($this->plugin->getDataFolder()."spawn.yaml", Config::YAML);
        if(!$sender instanceof Player){
            if(!isset($args[0])) return false;
        }
        if($cmd->getName() === "spawn"){
         if(!isset($args[0])){
       
          $getX = $this->spawn->get("getX");
          $getY = $this->spawn->get("getY");
          $getZ = $this->spawn->get("getZ");
          $getWorld = $this->spawn->get("world");
         if($getX === False){
             $sender->sendMessage(TF::RED."[MeetMate] > Spawn nie został ustawiony");
             return true;
        
         }
 

        $tp = new Position($getX, $getY, $getZ, $this->plugin->getServer()->getLevelByName($getWorld));
        $sender->sendMessage(TF::GREEN."[MeetMate] > Zostaniesz teleportowany za 5 sekund");
        sleep(5);
        $sender->teleport($tp);
        $sender->getLevel()->addSound(new $sound($sender));
        $sender->sendMessage(TF::GREEN."[MeetMate] > Teleportowano na spawn");

    }else{
        if($sender->hasPermission("essentials.spawn.other") || $sender->hasPermission("essentials.admin")){
           
          // tepanie innego gracza  
          $target = $this->plugin->getServer()->getPlayer($args[0]);
         if($target){ 
             $getX = $this->spawn->get("getX");
             $getY = $this->spawn->get("getY");
             $getZ = $this->spawn->get("getZ");
             $getWorld = $this->spawn->get("world");
             $tp = new Position($getX, $getY, $getZ, $this->plugin->getServer()->getLevelByName($getWorld));
             $target->teleport($tp);
             $target->getLevel()->addSound(new $sound($target));

             $sender->sendMessage(TF::GREEN."[MeetMate] > Teleportowano na spawn gracza ".$target->getName());
             $target->sendMessage(TF::GREEN."[MeetMate] > Teleportowano na spawn");
         }
        }


        
    }
    }
   if($cmd->getName() === "setspawn"){
    if($sender->hasPermission("essentials.setspawn") || $sender->hasPermission("essentials.admin")){
        // $this->spawn = new Config($this->plugin->getDataFolder()."spawn.yaml", Config::YAML);
       if($sender instanceof Player){
        $getWorld = $sender->getLevel()->getName();
        $getx = round($sender->getX());
        $gety = round($sender->getY());
        $getz = round($sender->getZ());
        $getX = $this->spawn->set("getX", $getx);
        $getY = $this->spawn->set("getY", $gety);
        $getZ = $this->spawn->set("getZ", $getz);
        $getWorld = $this->spawn->set("world", $getWorld);
        $this->spawn->save();
        $sender->sendMessage(TF::GREEN."[MeetMate] > Spawn został ustawiony na X:{$getx}/Y:{$gety}/Z:{$getz} świat: ".$sender->getLevel()->getName());
       }
    }
   }
    return true;
    }
}
