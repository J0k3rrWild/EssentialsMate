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


class Getpos extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        $this->plugin = $main;
        
    }


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
       
        
        
        if(!isset($args[0])){
            if($sender->hasPermission("essentials.getpos") || $sender->hasPermission("essentials.admin")){
                if ($sender->getName() === "CONSOLE"){
                    return false;
                }
                
                $getx = round($sender->getX());
                $gety = round($sender->getY());
                $getz = round($sender->getZ());
                $sender->sendMessage(TF::GREEN."[MeetMate] > Twoja lokalizacja to: X:".$getx." Y:".$gety." Z:".$getz);
                
            }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
                return true;
            }
        }
        if(isset($args[0])){
             if($sender->hasPermission("essentials.getpos.other") || $sender->hasPermission("essentials.admin")){
               $target = $this->plugin->getServer()->getPlayer($args[0]);
               if($target){
          
                $getx = round($target->getX());
                $gety = round($target->getY());
                $getz = round($target->getZ());
                $sender->sendMessage(TF::GREEN."[MeetMate] > Lokalizacja gracza ".$target->getName()." to: X:".$getx." Y:".$gety." Z:".$getz);
               
                
               }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Gracza nie ma na serverze");
                 
               }
             }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
             }
            }
        
     return true;
    }
    
}