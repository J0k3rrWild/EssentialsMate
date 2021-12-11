<?php

declare(strict_types=1);

namespace J0k3rrWild\EssentialsMate;

//Pocketmine
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as TF;
use pocketmine\Player;
use pocketmine\entity\object\ItemEntity;

//Events use
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerExhaustEvent;

//Command use
use J0k3rrWild\EssentialsMate\Commands\Mute;
use J0k3rrWild\EssentialsMate\Commands\Unmute;
use J0k3rrWild\EssentialsMate\Commands\Msg;
use J0k3rrWild\EssentialsMate\Commands\HealFeed;
use J0k3rrWild\EssentialsMate\Commands\Getpos;
use J0k3rrWild\EssentialsMate\Commands\Repair;
use J0k3rrWild\EssentialsMate\Commands\Vanish;
use J0k3rrWild\EssentialsMate\Commands\God;
use J0k3rrWild\EssentialsMate\Commands\Fly;
use J0k3rrWild\EssentialsMate\Commands\Ban;
use J0k3rrWild\EssentialsMate\Commands\Unban;
use J0k3rrWild\EssentialsMate\Commands\Gamemode;
use J0k3rrWild\EssentialsMate\Commands\Op;
use J0k3rrWild\EssentialsMate\Commands\Deop;

class Main extends PluginBase implements Listener{


public $godMode;
public $vanished;
public $deco;
public $msg = array("/msg","/tell", "/w");
public $unregister = array("tell", "ban", "unban", "pardon", "gamemode", "gm", "op", "deop", "kick");



    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        //config logger
        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder()."players/");
        $this->saveResource("vanished.json"); 
        $cfg = $this->getDataFolder() . 'vanished.json';
        $json = file_get_contents($cfg);
        $this->vanished = json_decode($json, true);
          

        
         
        //Pocketmine command unregister   
        foreach($this->unregister as $disable){
        $commandMap = $this->getServer()->getCommandMap();
        $command = $commandMap->getCommand($disable);
        $command->setLabel($disable."_disabled");
        $command->unregister($commandMap);
        }
        $commandMap->register("tell", new Commands\Msg($this));
        $commandMap->register("ban", new Commands\Ban($this));
        $commandMap->register("pardon", new Commands\Unban($this));
        $commandMap->register("gamemode", new Commands\Gamemode($this));
        $commandMap->register("op", new Commands\Op($this));
        $commandMap->register("deop", new Commands\Deop($this));
        $commandMap->register("kick", new Commands\Kick($this));
    
        
    
// ---------------------------------------------------------------------------------------

        //Essentials command register
        $this->getCommand("mute")->setExecutor(new Commands\Mute($this));
        $this->getCommand("unmute")->setExecutor(new Commands\Unmute($this));
        $this->getCommand("heal")->setExecutor(new Commands\HealFeed($this));
        $this->getCommand("getpos")->setExecutor(new Commands\Getpos($this));
        $this->getCommand("repair")->setExecutor(new Commands\Repair($this));
        $this->getCommand("vanish")->setExecutor(new Commands\Vanish($this));
        $this->getCommand("god")->setExecutor(new Commands\God($this));
        $this->getCommand("fly")->setExecutor(new Commands\Fly($this));
        $this->getCommand("ban")->setExecutor(new Commands\Ban($this));
        $this->getCommand("op")->setExecutor(new Commands\Op($this));
        $this->getCommand("deop")->setExecutor(new Commands\Deop($this));
        $this->getCommand("kick")->setExecutor(new Commands\Kick($this));
        $this->getCommand("adminfo")->setExecutor(new Commands\Adminfo($this));

        //Gamemode command alliases & register
        $this->getCommand("gamemode")->setExecutor(new Commands\Gamemode($this));
        $this->getCommand("gmc")->setExecutor(new Commands\Gamemode($this));
        $this->getCommand("gma")->setExecutor(new Commands\Gamemode($this));
        $this->getCommand("gms")->setExecutor(new Commands\Gamemode($this));
        

        //Unban command alliases & register
        $this->getCommand("pardon")->setExecutor(new Commands\Unban($this));
        $this->getCommand("unban")->setExecutor(new Commands\Unban($this));
        
        //Msg command alliases & register
        $this->getCommand("tell")->setExecutor(new Commands\Msg($this));
        $this->getCommand("msg")->setExecutor(new Commands\Msg($this));
        $this->getCommand("w")->setExecutor(new Commands\Msg($this));
        
// --------------------------------------------------------------------------------------


        $this->getLogger()->info(TF::GREEN."[EssentialsMate] > Plugin oraz konfiguracja została załadowana pomyślnie");
    }
    
    public function getVanish() { 
        return new Vanish($this);
      }

      public function getGod() { 
        return new God($this);
      }



    public function onMuted(PlayerChatEvent $p){
        $this->deco = new Config($this->getDataFolder()."players/". strtolower($p->getPlayer()->getName()) . "/player.yaml", Config::YAML);
        if($this->deco->get("muted") === true){
            $p->getPlayer()->sendMessage(TF::RED."[MeetMate] > Nie możesz pisać na chacie ponieważ jesteś zmutowany!");
            $p->setCancelled(true);
        }
        
    }
   
    public function onMutedCommand(PlayerCommandPreprocessEvent $e){
        $this->deco = new Config($this->getDataFolder()."players/". strtolower($e->getPlayer()->getName()) . "/player.yaml", Config::YAML);
        if($this->deco->get("muted") === true){
          $command = explode(" ", strtolower($e->getMessage()));
            if(in_array($command[0], $this->msg)){
                $e->getPlayer()->sendMessage(TF::RED."[MeetMate] > Nie możesz pisać prywatynch wiadomości ponieważ jesteś zmutowany!");
                $e->setCancelled(true);

            }
        }
        
    }

    public function onPrivDisabled(PlayerCommandPreprocessEvent $e){
        $command = explode(" ", strtolower($e->getMessage()));
        if(isset($command[1])){
            if(in_array($command[0], $this->msg)){
                $target = $this->getServer()->getPlayer($command[1]);
                // var_dump($target." ".$command[1]);
            if($target){ 
                $this->deco = new Config($this->getDataFolder()."players/". $command[1] . "/player.yaml", Config::YAML);
                $checkmsg = $this->deco->get("priv-disabled");
                if($checkmsg === true){
                   if($e->getPlayer()->hasPermission("essentials.admin") || $e->getPlayer()->hasPermission("essentials.msg.force")){  
                    $e->setCancelled(false);
                   }else{
                    $e->getPlayer()->sendMessage(TF::RED."[MeetMate] > Gracz ".$command[1]." ma wyłączone prywatne wiadomości");
                    $e->setCancelled(true);
                   }
                }
            }
            }
        }
    }
    

    public function onVanished(PlayerMoveEvent $p){
        if(in_array($p->getPlayer()->getName(), $this->vanished)){
            $p->getPlayer()->addActionBarMessage(TF::RED."[MeetMate] > Jesteś niewidzialny, użyj /vanish off by z powrotem stać się widzialny");

        }

    }

    public function onJoinPlayersVanishUpdate(PlayerJoinEvent $p){
        $cfg = $this->getDataFolder() . 'vanished.json';
        $json = file_get_contents($cfg);
        $this->vanished = json_decode($json, true);
        foreach($this->vanished as $vanish){
         $this->getVanish()->hideJoin($vanish);
        }

    }
    
    public function onGodModeHealth(EntityDamageEvent $p){
        $victim = $p->getEntity();
        if($victim instanceof Player){
            $this->deco = new Config($this->getDataFolder()."players/". strtolower($victim->getName()) . "/player.yaml", Config::YAML);
            if($this->deco->get("godmode", true)){
                $p->setCancelled(true);
            }
        }
    }

    public function onGodModeHunger(PlayerExhaustEvent $p){
            $this->deco = new Config($this->getDataFolder()."players/". strtolower($p->getPlayer()->getName()) . "/player.yaml", Config::YAML);
            if($this->deco->get("godmode", true)){
                $p->setCancelled(true);
             
            }else{
                $p->setCancelled(false);
            }
        
        }

    

    public function onJoinNew(PlayerJoinEvent $p){
        // var_dump($this->getDataFolder()."players/".$p->getPlayer()->getName());
        if(!is_dir($this->getDataFolder()."players/".strtolower($p->getPlayer()->getName()))){

            @mkdir($this->getDataFolder()."players/".strtolower($p->getPlayer()->getName()));
            $playerData = fopen($this->getDataFolder()."players/".strtolower($p->getPlayer()->getName())."/player.yaml", "w");
            $data = "muted: false\nfreezed: false\npriv-disabled: false\ngodmode: false\nfly: false\ngamemode: survival";
            fwrite($playerData, $data);
            fclose($playerData);
            $this->deco = new Config($this->getDataFolder()."players/". strtolower($p->getPlayer()->getName()) . "/player.yaml", Config::YAML);
            $this->getLogger()->info(TF::GREEN."[EssentialsMate] > Nie wykryto gracza ".$p->getPlayer()->getName()." w bazie, tworze profil...");
            
        }
        // else{
        
        //     $this->deco = new Config($this->getDataFolder()."players/". strtolower($p->getPlayer()->getName()) . "/player.yaml", Config::YAML);
        // }
        
            
    }
    
    public function onJoinFly(PlayerJoinEvent $p){
         $this->deco = new Config($this->getDataFolder()."players/". strtolower($p->getPlayer()->getName()) . "/player.yaml", Config::YAML);
         if($this->deco->get("fly", true)){
             $p->getPlayer()->sendMessage(TF::GREEN."[MeetMate] > Masz aktywowaną funkcje latania ponieważ nie została wyłączona podczas ostatniej sesji");
             $p->getPlayer()->setFlying(true);
             $p->getPlayer()->setAllowFlight(true);
             
         }
        
     }

}
