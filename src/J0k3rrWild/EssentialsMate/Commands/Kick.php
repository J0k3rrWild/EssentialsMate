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



//Main
use J0k3rrWild\EssentialsMate\Main;


class Kick extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        parent::__construct("kick", $main);
        $this->setUsage("/kick all <powod> | <player> <powod>");
        $this->setDescription("Wyrzuca gracza z serwera");
        $this->plugin = $main;
    }

    
         




    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        if(!isset($args[0])) return false;

       if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.kick")){
        

        if(strtolower($args[0]) === "all"){
            $name = array_shift($args);
            $reason = implode(" ", $args);
            $target = $this->plugin->getServer()->getPlayer($name);
            if($sender->hasPermission("essentials.kick.all") || $sender->hasPermission("essentials.admin")){
               $players =  $this->plugin->getServer()->getOnlinePlayers();
                $i = 0;
                foreach($players as $p){
                 if(!($p->hasPermission("essentials.kick.bypass")) || !($p->hasPermission("essentials.admin"))){
                     $i++;
                    $p->kick($reason !== "" ? TF::RED."§l[MeetMate] > Wszyscy gracze zostali wyrzuceni z serwera. Powód: ". $reason : TF::RED."§l[MeetMate] > Wszyscy gracze zostali wyrzuceni z serwera. Powód: Nie określono", false);
                 }
                }
                $sender->sendMessage(TF::GREEN."[MeetMate] > Wyrzuciłeś ".$i." graczy z serwera");
                foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
                    if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
                        if($sender !== $p){
                        $p->sendMessage(TF::GRAY."[{$sender->getName()}: Wyrzucono WSZYSTKICH graczy z serwera. Powód: {$reason}]");
                        }
                       }
                       $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Wyrzucono WSZYSTKICH graczy z serwera. Powód: {$reason}]");
                   }
            }else{
                $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
            }
            return true;
        }
        $name = array_shift($args);
        $reason = implode(" ", $args);
        $target = $this->plugin->getServer()->getPlayer($name);
        
        if(!$target){
          $sender->sendMessage(TF::RED."[MeetMate] > Niepoprawny nick lub gracz jest offline");
          return true;
        }

        if(strtolower($name) === strtolower($sender->getName())){
            $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz wyrzucić samego siebie!");
            return true;
        }
        if($target){
            if(($target->hasPermission("essentials.kick.bypass") && $sender instanceof Player) || ($target->hasPermission("essentials.admin") && $sender instanceof Player)){
                $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz wyrzucić tego użytkownika! Użyj komendy w konsoli");
                return true;
            }
        
        }
       
        
         
        foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
         if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
             if($sender !== $p){
             $p->sendMessage(TF::GRAY."[{$sender->getName()}: Wyrzucono gracza {$name} z serwera. Powód: {$reason}]");
             }
            }
        }
        $sender->sendMessage(TF::GREEN."[MeetMate] > Wyrzucono gracza {$name}");
        $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Wyrzucono gracza {$name} z serwera. Powód: {$reason}]");

         if($target){
             $target->kick($reason !== "" ? TF::RED."§l[MeetMate] > Zostałeś wyrzucony z serwera. Powód: ". $reason : TF::RED."§l[MeetMate] > Zostałeś wyrzucony z serwera. Powód: Nie określono", false);
         }
       }else{
         $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
       }
      return true;
    }
}