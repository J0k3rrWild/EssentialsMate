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
        $reasonc = implode(" ", $args);
        $target = $this->plugin->getServer()->getPlayer($name);

        if(strtolower($name) === strtolower($sender->getName())){
            $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz zbanować samego siebie!");
            return true;
        }
        if($target){
            if(($target->hasPermission("essentials.ban.bypass") && $sender instanceof Player) || ($target->hasPermission("essentials.admin") && $sender instanceof Player)){
                $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz zbanować tego użytkownika! Użyj komendy w konsoli");
                return true;
            }
        }

        foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
         if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
             if($sender !== $p){
             $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zbanowano gracza {$name} pernamentnie. Powód: {$reason}]");
             }
            }
        }
        $sender->getServer()->getNameBans()->addBan($name, $reason, null, $sender->getName());
        $this->plugin->deco = new Config($this->plugin->getDataFolder()."players/". strtolower($name) . "/player.yaml", Config::YAML);
        $this->plugin->deco->set("banned", true);
        if($reasonc === ""){
            $reasonc = "Nie określono";
        }
        $this->plugin->deco->set("reasonban", $reasonc);
        $this->plugin->deco->save();
        $sender->sendMessage(TF::GREEN."[MeetMate] > Zbanowano gracza {$name} pernamentnie]");
        $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zbanowano gracza {$name} pernamentnie. Powód: {$reason}]");

         if($target){
             $target->kick($reason !== "" ? TF::RED."§l[MeetMate] > Zostałeś zbanowany pernamentnie na serwerze. Powód: ". $reason : TF::RED."§l[MeetMate] > Zostałeś zbanowany pernamentnie na serwerze. Powód: Nie określono", false);
         }
       }else{
         $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
       }
      return true;
    }
}