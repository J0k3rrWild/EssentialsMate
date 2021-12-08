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


class Unban extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        parent::__construct("pardon", $main, ["unban"]);
        $this->setUsage("/pardon <player> || /unban <player>");
        $this->setDescription("Odbanowywuje gracza na nick");
        $this->plugin = $main;
    }

    
         




    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        if(!isset($args[0])) return false;

       if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.ban")){

        if(strtolower($args[0]) === strtolower($sender->getName())){
            $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz odbanować samego siebie!");
            return true;
        }

        $sender->getServer()->getNameBans()->remove($args[0]);
       
        foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
         if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
             if($sender !== $p){
             $p->sendMessage(TF::GRAY."[{$sender->getName()}: Odbanowano gracza ".$args[0]."]");
             }
            }
        }
        $sender->sendMessage(TF::GREEN."[MeetMate] > Odbanowano gracza ".$args[0]);
        $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Odbanowano gracza ".$args[0]."]");

       }else{
         $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
       }
      return true;
    }
}