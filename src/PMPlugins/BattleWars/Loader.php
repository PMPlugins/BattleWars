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

class Loader extends PluginBase{ 

		/** @var string AUTHOR Plugin author(s) */
		const AUTHOR = "Legoboy0215";
	
		/** @var string VERSION Plugin version */
		const VERSION = "1.0.0";
	
		/** @var string PREFIX Plugin message prefix */
		const PREFIX = "[BattleWars]";

        public function onEnable(){
			if(!file_exists($this->getDataFolder())){
				@mkdir($this->getDataFolder());
			}
			$this->setting = new Config($this->getDataFolder() . "setting.yml", Config::YAML, array
            (
				"signtext1" => "[BattleWars]",
				"signtext_blue" => "[Blue]",
				"signtext_red" => "[Red]",
				"signtext_green" => "[Green]",
				"signtext_yellow" => "[Yellow]",
				"game_time_sec" => 600,
                "max_player_per_team" => 6,
                "min_players_total" => 4,
                "waiting_time_sec" => 20,
                "game_time_sec" => 600,
            )
			);
<<<<<<< HEAD
			$this->arena = new Config($this->getDataFolder() . "arena.yml", Config::YAML, array
            (
				"arena-1" => array(
					"enabled" => true,
					"waiting_world" => "",
					"arena_name" => "",
					"team_spawn_locs" => array(
						array(1,2,3),
						array(1,2,3),
						array(1,2,3),
						array(1,2,3),
					),
				)
				"arena-2" => array(
					"enabled" => false,
					"waiting_world" => "",
					"arena_name" => "",
					"team_spawn_locs" => array(
						array(1,2,3),
						array(1,2,3),
						array(1,2,3),
						array(1,2,3),
					),
				)
				"arena-3" => array(
					"enabled" => false,
					"waiting_world" => "",
					"arena_name" => "",
					"team_spawn_locs" => array(
						array(1,2,3),
						array(1,2,3),
						array(1,2,3),
						array(1,2,3),
					),
				)
				"arena-4" => array(
					"enabled" => false,
					"waiting_world" => "",
					"arena_name" => "",
					"team_spawn_locs" => array(
						array(1,2,3),
						array(1,2,3),
						array(1,2,3),
						array(1,2,3),
					),
				)
				"arena-5" => array(
					"enabled" => false,
					"waiting_world" => "",
					"arena_name" => "",
					"team_spawn_locs" => array(
						array(1,2,3),
						array(1,2,3),
						array(1,2,3),
						array(1,2,3),
					),
				)
            )
			);
			$this->arena1status = $this->arena->get("arena-1")['enabled'];
			$this->arena2status = $this->arena->get("arena-2")['enabled'];
			$this->arena3status = $this->arena->get("arena-3")['enabled'];
			$this->arena4status = $this->arena->get("arena-4")['enabled'];
			$this->arena5status = $this->arena->get("arena-5")['enabled'];
			$this->pureperms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
            $this->getLogger()->info(TextFormat::GREEN . "BattleWars has been started and configured!"); 
			$this->startMatches();
=======
			/** @var string players Game list of players */
		    $this->players = array();
			$this->blue = array();
			$this->red = array();
			$this->green = array();
			$this->yellow = array();
			$this->gameworld = $this->setting->get("battlewars_gameworld");
			$this->waitworld = $this->setting->get("battlewars_waitinglobby");
			if(!$this->getServer()->isLevelLoaded($this->gameworld)){
			    $this->getServer()->loadLevel($this->gameworld);
			    $this->getServer()->loadLevel($this->waitworld);
			}
			$this->pureperms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
            		$this->getLogger()->info(TextFormat::GREEN . "BattleWars has been started and configured!"); 
			$this->startGame();
>>>>>>> origin/master
        }

        public function onDisable(){
			$this->setting->save();
<<<<<<< HEAD
			$this->arena->save();
            $this->getLogger()->info(TextFormat::RED . "BattleWars has been stopped and configuration has been saved!");
=======
            		$this->getLogger()->info(TextFormat::RED . "BattleWars has been stopped and configuration has been saved!");
>>>>>>> origin/master
        }

<<<<<<< HEAD
		public function startMatches(){
			if($this->arena1status){
				$arena = new ArenaManager(1, $this);
=======
		public function endGame(){
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
>>>>>>> origin/master
			}
			if($this->arena2status){
				$arena = new ArenaManager(2, $this);
			}
<<<<<<< HEAD
			if($this->arena3status){
				$arena = new ArenaManager(3, $this);
=======
		}
		
		/**
		* @param string $match
		* @return bool
		*/
		
		public function checkIfMatchFull(){
			$max = $this->setting->get("max_player_per_team") * 4;
			if(count($this->players) >= $max){
				return true;
			}else{
				return false;
>>>>>>> origin/master
			}
			if($this->arena4status){
				$arena = new ArenaManager(4, $this);
			}
			if($this->arena5status){
				$arena = new ArenaManager(5, $this);
			}
		}
		
		public function joinWorld(Player $player, $levelname){
			$level = $this->getServer()->getLevelByName($levelname);
			if($level instanceof Level){
				$player->teleport($level);
				$player->sendMessage(TextFormat::GREEN . "Teleporting...");
			}
		}
}
