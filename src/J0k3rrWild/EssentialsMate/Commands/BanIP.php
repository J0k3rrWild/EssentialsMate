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


class BanIP extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        parent::__construct("ban-ip", $main, ["banip"]);
        $this->setUsage("/banip <player> <powód>*");
        $this->setDescription("Banuje gracza na IP");
        $this->plugin = $main;
    }

    
         




    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        if(!isset($args[0])) return false;

       if($sender->hasPermission("essentials.admin") || $sender->hasPermission("essentials.banip")){
        $name = array_shift($args);
        $reason = implode(" ", $args);
        $target = $this->plugin->getServer()->getPlayer($name);

        if(strtolower($name) === strtolower($sender->getName())){
            $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz zbanować samego siebie!");
            return true;
        }
        if($target){
            if(($target->hasPermission("essentials.banip.bypass") && $sender instanceof Player) || ($target->hasPermission("essentials.admin") && $sender instanceof Player)){
                $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz zbanować tego użytkownika! Użyj komendy w konsoli");
                return true;
            }
        }
        

        if(preg_match("/^([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])$/", $name)){
            
            
            foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
                if($name===$player->getAddress()){
                 if(!($player->hasPermission("essentials.banip.bypass") && $sender instanceof Player) || !($player->hasPermission("essentials.admin") && $sender instanceof Player)){
                   $player->kick($reason !== "" ? TF::RED."§l[MeetMate] > Zostałeś zbanowany pernamentnie na serwerze. Powód: ". $reason : TF::RED."§l[MeetMate] > Zostałeś zbanowany pernamentnie na serwerze. Powód: Nie określono", false);
                 }else{
                    $sender->sendMessage(TF::RED."[MeetMate] > Nie możesz zbanować tego użytkownika! Użyj komendy w konsoli");
                    return true;
                 }
                }
            }
             
            foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
                if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
                    if($sender !== $p){
                    $p->sendMessage(TF::GRAY."[{$sender->getName()}: Zbanowano gracza {$name} na IP. Powód: {$reason}]");
                    }
                   }
               }

               $sender->getServer()->getIPBans()->addBan($name, $reason, null, $sender->getName());
			   $sender->sendMessage(TF::GREEN."[MeetMate] > Zbanowano IP ".$name." pomyślnie");
		}else{
			if($target){
				$sender->getServer()->getIPBans()->addBan($target->getAddress(), $reason, null, $sender->getName());

				$sender->sendMessage(TF::GREEN."[MeetMate] > Zbanowano IP ".$target->getAddress()." należącego do gracza ".$target);
			}else{
				$sender->sendMessage(TF::RED."[MeetMate] > Niepoprawny nick lub IP, upewnij sie że IP jest poprawne lub czy gracz jest online");

				return false;
			}

        $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Zbanowano gracza {$name} na IP. Powód: {$reason}]");

         if($target){
             $target->kick($reason !== "" ? TF::RED."§l[MeetMate] > Zostałeś zbanowany pernamentnie na serwerze. Powód: ". $reason : TF::RED."§l[MeetMate] > Zostałeś zbanowany pernamentnie na serwerze. Powód: Nie określono", false);
         }

         foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
             if($target->getAddress()===$player->getAddress()){
                $target->kick($reason !== "" ? TF::RED."§l[MeetMate] > Zostałeś zbanowany pernamentnie na serwerze. Powód: ". $reason : TF::RED."§l[MeetMate] > Zostałeś zbanowany pernamentnie na serwerze. Powód: Nie określono", false);
             }
         }
       
     
        }
    }else{
        $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz uprawnień by móc użyć tej komendy");
      }
      return true;
  }
}