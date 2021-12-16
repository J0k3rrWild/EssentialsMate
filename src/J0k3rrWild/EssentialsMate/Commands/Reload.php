<?php

declare(strict_types=1);

namespace J0k3rrWild\EssentialsMate\Commands;


use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\Config;



//Main
use J0k3rrWild\EssentialsMate\Main;


class Reload extends PluginCommand implements CommandExecutor{

public $plugin;

  
    public function __construct(Main $main) {
        parent::__construct("reload", $main);
        $this->setDescription("Przeładowywuje serwer");
        $this->setUsage("/reload");
        $this->plugin = $main;
    }

    
         


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
    
        if($sender->isOp()===true){
             $this->plugin->getServer()->reload();
             foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
                if($p->hasPermission("essentials.admin") || $p->hasPermission("essentials.logger")){
                    if($sender !== $p){
                    $p->sendMessage(TF::GRAY."[{$sender->getName()}: Przeładowano serwer]");
                    }
                   }
                   $this->plugin->getLogger()->info(TF::GRAY."[{$sender->getName()}: Przeładowano serwer]");
                }
                $sender->sendMessage(TF::RED."[MeetMate] > Przeładowano serwer pomyślnie");


        }else{
            $sender->sendMessage(TF::RED."[MeetMate] > Nie masz wystarczających uprawnień by użyć tej komendy");
        }

return true;
    }
}