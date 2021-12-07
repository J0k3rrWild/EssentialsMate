<?php

declare(strict_types=1);

namespace J0k3rrWild\EssentialsMate\Commands;


use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;




//Main
use J0k3rrWild\EssentialsMate\Main;


class HealFeed extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        $this->plugin = $main;
        
    }


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        $sound = "pocketmine\level\sound\FizzSound";
        // PopSound
       
        
        
        if(!isset($args[0])){
            if($sender->hasPermission("essentials.heal") || $sender->hasPermission("essentials.admin")){
                if ($sender->getName() === "CONSOLE"){
                 return false;
                }
                $sender->getPlayer()->setHealth($sender->getMaxHealth());
                $sender->getPlayer()->setFood(20);
                $sender->getPlayer()->setSaturation(20);

                $sender->getLevel()->addSound(new $sound($sender));
                $sender->sendMessage(TF::GREEN."[MeetMate] > Pomyślnie uzupełniono twoje życie oraz głód");
            }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
                return true;
            }
        }
        if(isset($args[0])){
             if($sender->hasPermission("essentials.heal.other") || $sender->hasPermission("essentials.admin")){
               $target = $this->plugin->getServer()->getPlayer($args[0]);
               if($target){
                $target->setHealth($target->getMaxHealth());
                $target->setFood(20);
                $target->setSaturation(20);
                
                if($sender->getName() === "CONSOLE"){
                    $target->getLevel()->addSound(new $sound($target));
                    $this->plugin->getLogger()->info(TF::GREEN."[MeetMate] > Głód oraz życie gracza ".$target->getName()." zostało zregenerowane");
                    $target->sendMessage(TF::GREEN."[MeetMate] > Twój głód oraz życie zostało zregenerowane");
                }else{
                    $target->getLevel()->addSound(new $sound($sender));
                    $target->getLevel()->addSound(new $sound($target));
                    $sender->sendMessage(TF::GREEN."[MeetMate] > Głód oraz życie gracza ".$target->getName()." zostało zregenerowane");
                    $target->sendMessage(TF::GREEN."[MeetMate] > Twój głód oraz życie zostało zregenerowane");
                }
                
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