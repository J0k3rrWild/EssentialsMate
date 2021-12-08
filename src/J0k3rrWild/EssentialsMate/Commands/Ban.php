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


class Ban extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        parent::__construct("ban", $main);
        $this->setUsage("/ban <player> <powód>");
        $this->setDescription("Banuje gracza na nick");
        $this->plugin = $main;
    }

    
         




    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        if(!isset($args[0])) return false;

       if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.ban")){
        $name = array_shift($args);
        $reason = implode(" ", $args);
        $target = $this->plugin->getServer()->getPlayer($name);

        if($target === $sender){
            $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz zbanować samego siebie!");
            return true;
        }

        if(($target->hasPermission("essentials.ban.bypass") && $sender instanceof Player) || ($target->hasPermission("essentials.admin") && $sender instanceof Player)){
            $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz zbanować tego użytkownika! Użyj komendy w konsoli");
            return true;
        }
        

        $sender->getServer()->getNameBans()->addBan($name, $reason, null, $sender->getName());
        $sender->sendMessage(TF::GREEN."[MeetMate] > Zbanowano gracza {$name}");
         
        foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
         if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.notify")){
             $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zbanowano gracza {$name} pernamentnie. Powód: {$reason}]");
         }
        }
        $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zbanowano gracza {$name} pernamentnie. Powód: {$reason}]");

         if($target){
             $target->kick($reason !== "" ? TF::RED."§l[MeetMate] > Zostałeś zbanowany pernamentnie na serwerze. Powód: ". $reason : TF::RED."§l[MeetMate] > Zostałeś zbanowany pernamentnie na serwerze. Powód: Nie określono");
         }
       }else{
         $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
       }
      return true;
    }
}