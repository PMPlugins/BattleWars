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
        }

        public function onDisable(){
			$this->setting->save();
			$this->arena->save();
            		$this->getLogger()->info(TextFormat::RED . "BattleWars has been stopped and configuration has been saved!");
            		$this->getLogger()->info(TextFormat::RED . "BattleWars has been stopped and configuration has been saved!");
        }

		public function startMatches(){
			if($this->arena1status){
				$arena = new ArenaManager(1, $this);
			}
			if($this->arena2status){
				$arena = new ArenaManager(2, $this);
			}
			if($this->arena3status){
				$arena = new ArenaManager(3, $this);
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
