<?php

namespace PMPlugins\BattleWars;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\tile\Sign;
use pocketmine\tile\Chest;

class Main extends PluginBase{ 

	/**
	* @return SuperAPI
	*/
	
		/** @var string AUTHOR Plugin author(s) */
		const AUTHOR = "Legoboy0215";
	
		/** @var string VERSION Plugin version */
		const VERSION = 1.0.0;
	
		/** @var string PREFIX Plugin message prefix */
		const PREFIX = "[BattleWars]";

        public function onEnable(){
	        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
			if(!file_exists($this->getDataFolder())){
				@mkdir($this->getDataFolder());
			}
			$this->setting = new Config($this->getDataFolder() . "setting.yml", Config::YAML, array
            (
			    "battlewars_waitinglobby" => "bwlobby",
				"battlewars_gameworld" => "bwgame",
				"signtext1" => "[BattleWars]",
				"signtext2" => "JOIN",
				"game_time_sec" => 600,
                "max_player_per_team" => 6,
                "team_spawn_locs" => array(
                    array(1,2,3),
                    array(1,2,3),
                    array(1,2,3),
                    array(1,2,3),
                ),
                "min_players_total" => 4,
                "waiting_time_sec" => 20,
                "game_time_sec" => 600,
            )
        );
			/** @var string players Game list of players */
		    $this->players = array();
			$this->blue = array();
			$this->red = array();
			$this->green = array();
			$this->yellow = array();
			$this->gameworld = $this->getServer()->getLevelByName($this->setting->get("battlewars_gameworld"));
			$this->waitlobby = $this->getServer()->getLevelByName($this->setting->get("battlewars_waitinglobby"));
			if(!$this->getServer()->isLevelLoaded($this->gameworld)){
			    $this->getServer()->loadLevel($this->gameworld);
			    $this->getServer()->loadLevel($this->waitlobby);
			}
			$this->pureperms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
            $this->getLogger()->info(TextFormat::GREEN . "BattleWars has been started and configured!"); 
			$this->startGame();
        }

        public function onDisable(){
			$this->setting->save();
			
            $this->getLogger()->info(TextFormat::RED . "BattleWars has been stopped and configuration has been saved!");
        }
		
		public function startGame($game){
		}

		public function endGame($game){
		}
	    ///////////////////////////API-Functions\\\\\\\\\\\\\\\\\\\\\\\
		
		function array_mt_rand(array $a){
            return array_values($a)[mt_rand(0, count($a) - 1)];
        }
		
		public function addToTeam(Player $player, $team){
			switch(strtolower($team)){
				case "blue":
					if($this->checkIfTeamFull($team)){
						array_push($this->blue, $p->getName());
						$player->setNameTag(TextFormat::BLUE . $p->getName()); 
						$player->setDisplayName(TextFormat::BLUE . $p->getName());
						$player->sendMessage(TextFormat::BLUE . "You joined the blue team!");
					}else{
						$player->sendMessage(TextFormat::RED . "Sorry, the blue team is full!");
					}
					break;
				case "red":
					if($this->checkIfTeamFull($team)){
						array_push($this->red, $p->getName());
						$player->setNameTag(TextFormat::BLUE . $p->getName()); 
						$player->setDisplayName(TextFormat::BLUE . $p->getName());
						$player->sendMessage(TextFormat::BLUE . "You joined the red team!");
					}else{
						$player->sendMessage(TextFormat::RED . "Sorry, the red team is full!");
					}
					break;
				case "green":
					if($this->checkIfTeamFull($team)){
						array_push($this->blue, $p->getName());
						$player->setNameTag(TextFormat::BLUE . $p->getName()); 
						$player->setDisplayName(TextFormat::BLUE . $p->getName());
						$player->sendMessage(TextFormat::BLUE . "You joined the green team!");
					}else{
						$player->sendMessage(TextFormat::RED . "Sorry, the green team is full!");
					}
					break;
				case "yellow":
					if($this->checkIfTeamFull($team)){
						array_push($this->yellow, $p->getName());
						$player->setNameTag(TextFormat::YELLOW . $p->getName()); 
						$player->setDisplayName(TextFormat::YELLOW . $p->getName());
						$player->sendMessage(TextFormat::YELLOW . "You joined the yellow team!");
					}else{
						$player->sendMessage(TextFormat::RED . "Sorry, the yellow team is full!");
					}
					break;
			}
		}
		
		/**
		* @param string $team
		* @return bool
		*/
		
		public function checkIfTeamFull($team){
			$max = $this->setting->get("max_player_per_team");
			switch($strtolower($team)){
				case "blue":
					if(count($this->blue) >= $max){
						return true;
					}else{
						return false;
					}
					break;
				case "red":
					if(count($this->red) >= $max){
						return true;
					}else{
						return false;
					}
					break;
				case "green":
					if(count($this->green) >= $max){
						return true;
					}else{
						return false;
					}
					break;
				case "yellow":
					if(count($this->yellow) >= $max){
						return true;
					}else{
						return false;
					}
					break;
			}
		}
		
		/**
		* @param string $match
		* @return bool
		*/
		
		public function checkIfGameFull(){
			$max = $this->setting->get("max_player_per_team") * 4;
			if(count($this->players) >= $max){
				return true;
			}else{
				return false;
			}
		}
		
		/**
		* @param string $message
		* @return bool
		*/
		
		public function broadcastGameMessage($message){
			foreach($this->players as $p){
				$player = $this->getServer()->getPlayer($p);
				$player->sendMessage($message);
				return true;
			}
			return false;
		}
}