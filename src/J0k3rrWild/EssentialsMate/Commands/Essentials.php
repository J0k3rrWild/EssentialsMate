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


class Essentials extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        $this->plugin = $main;
        
    }


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        if(!isset($args[0])){
           $sender->sendMessage(TF::GREEN."|-------------------[EssentialsMate]-------------------|");
           $sender->sendMessage(TF::GREEN."Author: J0k3rrWild dla MeetMate.pl");
           $sender->sendMessage(TF::GREEN."Github: https://github.com/J0k3rrWild/");
           $sender->sendMessage(TF::GREEN."Wersja: EssentialsMate 1.1.7");
           $sender->sendMessage(TF::GREEN."API: 3.26.2");
           $sender->sendMessage(TF::GREEN."");
           $sender->sendMessage(TF::GREEN."Wpisz /essentials help by zobaczyc liste dostepnych komend essentials (wymaga specjalnych uprawnien)");
           $sender->sendMessage(TF::GREEN."|-------------------[EssentialsMate]-------------------|");
           return true;
        } 
        if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials")){    
         if(strtolower($args[0])==="help"){
            $sender->sendMessage(TF::GREEN."|-------------------[EssentialsMate]-------------------|");
            $sender->sendMessage(TF::GREEN."                    [ Strona 1 z 1 ]");
            $sender->sendMessage(TF::GREEN."");
            $sender->sendMessage(TF::GREEN."");
            $sender->sendMessage(TF::GREEN."");
            $sender->sendMessage(TF::GREEN."");
            $sender->sendMessage(TF::GREEN."");
            $sender->sendMessage(TF::GREEN."");
            $sender->sendMessage(TF::GREEN."");
            $sender->sendMessage(TF::GREEN."");
            $sender->sendMessage(TF::GREEN."");
            $sender->sendMessage(TF::GREEN."");
            $sender->sendMessage(TF::GREEN."|-------------------[EssentialsMate]-------------------|");
         }
        }else{
            $sender->sendMessage(TF::RED."[MeetMate] > Nie masz stosownych uprawnień by móc użyć tą komende");
        }
        return true;
    }
}