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


class Repair extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        $this->plugin = $main;
        
    }


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        $sound = "pocketmine\level\sound\AnvilUseSound";
       
        
        
   
            if((isset($args[0]) && $args[0] === "all") && !isset($args[1])){
             if($sender->hasPermission("essentials.repair") || $sender->hasPermission("essentials.admin")){
                if($sender->getName() === "CONSOLE"){
                    return false;
                }else{
                   
                    $inv = $sender->getInventory()->getContents();
                   foreach($inv as $index => $item){
                    $sender->getInventory()->setItem($index, $item->setDamage(0));;
                    
                   
                }
                    $sender->getLevel()->addSound(new $sound($sender));
                    $sender->sendMessage(TF::GREEN."[MeetMate] > Twoje itemy zostały pomyślnie naprawione!\n\n\nUWAGA!\n\nBy naprawić zbroje musisz ją najpierw schować do plecaka");
                }
             }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
                return true;
                 
             }
            }else{
                if(!isset($args[0])){
                    if($sender->getName() === "CONSOLE"){
                        return false;
                    }

                    $inv = $sender->getInventory();
                    $item = $inv->getItemInHand();
                    $item->setDamage(0);
                    $inv->setItemInHand($item);
                    $sender->getLevel()->addSound(new $sound($sender));
                    $sender->sendMessage(TF::GREEN."[MeetMate] > Twój item został pomyślnie naprawiony");
                    }
                
            }
          
        
        if(isset($args[0])){
             if($sender->hasPermission("essentials.repair.other") || $sender->hasPermission("essentials.admin")){
              if($args[0] !== "all" && isset($args[0])){
               $target = $this->plugin->getServer()->getPlayer($args[0]);
               if($target){
          
                    $inv = $target->getInventory();
                    $item = $inv->getItemInHand();
                    $item->setDamage(0);
                    $inv->setItemInHand($item);
                    $target->getLevel()->addSound(new $sound($target));
                    $target->sendMessage(TF::GREEN."[MeetMate] > Twój item został pomyślnie naprawiony");
                    $sender->sendMessage(TF::GREEN."[MeetMate] > Item gracza ".$target->getName()." został pomyślnie naprawiony");
               
                
               }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Gracza nie ma na serverze");
                 
               }

             }else{
                if($args[0] === "all" && isset($args[1])){
                    $target = $this->plugin->getServer()->getPlayer($args[1]);
                  if($target){  
                    $inv = $target->getInventory()->getContents();
                   foreach($inv as $index => $item){
                    $target->getInventory()->setItem($index, $item->setDamage(0));;
                    
                   
                  }
                    $target->getLevel()->addSound(new $sound($target));
                    $target->sendMessage(TF::GREEN."[MeetMate] > Twoje itemy zostały pomyślnie naprawione!\n\n\nUWAGA!\n\nBy twoja zbroja została naprawiona musisz ją najpierw schować do plecaka");
                    $sender->sendMessage(TF::GREEN."[MeetMate] > Itemy gracza ".$args[1]." zostały pomyślnie naprawione!");
                 }else{
                    $sender->sendMessage(TF::RED."[MeetMate] > Gracza nie ma na serverze");
                 }
                }
             }
             }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
             }
            }
        
     return true;
    }
    
}