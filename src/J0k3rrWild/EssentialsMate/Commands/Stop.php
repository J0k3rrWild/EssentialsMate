<?php

declare(strict_types=1);

namespace J0k3rrWild\EssentialsMate\Commands;


use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;
use J0k3rrWild\EssentialsMate\Commands\Tasks\Stop\StopSchelud;




//Main
use J0k3rrWild\EssentialsMate\Main;


class Stop extends PluginCommand implements CommandExecutor{

public $plugin;
public $none;
  
    public function __construct(Main $main) {
        parent::__construct("stop", $main);
        $this->setUsage("/stop <reason>*");
        $this->setDescription("Wyłącza awaryjnie serwer");
        $this->plugin = $main;
        
    }


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
     
     if($sender->isOp() === true){
        if(isset($args[0])){

        $task = new StopSchelud($this, $args[0]); 
        $this->plugin->getScheduler()->scheduleRepeatingTask($task,1*20); // Counted in ticks (1 second = 20 ticks)
        }else{
            
        $task = new StopSchelud($this, $this->none); 
        $this->plugin->getScheduler()->scheduleRepeatingTask($task,1*20); // Counted in ticks (1 second = 20 ticks)
        }
      
     }else{
         $sender->sendMessage(TF::RED."[MeetMate] > Nie posiadasz stosownych uprawnień by użyć komendy");
     }
    return true;
    }


}