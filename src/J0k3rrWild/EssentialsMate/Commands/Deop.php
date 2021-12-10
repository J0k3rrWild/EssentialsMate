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


class Deop extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        parent::__construct("deop", $main);
        $this->setUsage("/deop <nick> ");
        $this->setDescription("Zarządza operatorami");
        $this->plugin = $main;
    }

    
         




    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        if(!isset($args[0])) return false;

     if($sender->isOp()){
      if($sender instanceof Player){
       if(isset($args[0]) && ($cmd->getName() === "deop")){
        $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz użyć tej komendy w grze, by odebrać operatora użyj konsoli");
       }
       }else{
         $target = $sender->getServer()->getOfflinePlayer($args[0]);
         $targeton = $sender->getServer()->getPlayer($args[0]);
         $target->setOp(false);
         $sender->sendMessage(TF::GREEN."[MeetMate] > Odebrałeś operatora dla gracza: {$target->getName()}");
         if($targeton){
         $targeton->sendMessage(TF::RED."[MeetMate] > Gracz {$sender->getName()} odebrał ci operatora");
         }
         foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
            if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
                if($sender !== $p){
                $p->sendMessage(TF::GRAY."[{$sender->getName()}: Odebrano operatora dla: {$target->getName()}]");
                }
               }
           }
     }
    }else{
        $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
    }
    
    
     return true;
    }
    
}
