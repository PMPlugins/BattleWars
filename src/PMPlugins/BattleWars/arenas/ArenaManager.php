<?php

namespace PMPlugins\BattleWars\arenas;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\math\Vector3;
use pocketmine\tile\Tile;
use pocketmine\tile\Sign;
use pocketmine\level\Level;
use pocketmine\level\Position;
use PMPlugins\BattleWars\Loader;

class ArenaManager implements Listener{ 
	
		public function __construct($arenaname, Loader $plugin){
			$this->plugin = $plugin;
			$this->arenaname = $arenaname;
			$this->blue = array();
			$this->red = array();
			$this->green = array();
			$this->yellow = array();
			$this->plugin->getServer()->getPluginManager()->registerEvents($this, $this);
		}
		
		public function onSignTap(PlayerInteractEvent $event){
			$player = $event->getPlayer();
			$name = $player->getName();
			$tile = $player->getLevel()->getTile($event->getBlock());
			$waitworld = $this->plugin->arena->get($this->arenaname)['waiting_world'];
			$matchworld = $this->plugin->arena->get($this->arenaname)['arena_names'];
			$group = $this->plugin->pureperms->getUser($player)->getGroup()->getName();
			$blue = trim(strtolower($this->plugin->setting->get("signtext_blue")));
			$red = trim(strtolower($this->plugin->setting->get("signtext_red")));
			$green = trim(strtolower($this->plugin->setting->get("signtext_green")));
			$yellow = trim(strtolower($this->plugin->setting->get("signtext_yellow")));

			if($tile instanceof Sign){
				$text = $tile->getText();
				$final = trim(strtolower($this->plugin->setting->get("signtext1")));
				if(TextFormat::clean(trim(strtolower($text[0]))) === $final){
					switch(TextFormat::clean(trim(strtolower($text[1])))){
						case $blue:
							$this->addToTeam($player, "blue");
							return true;
							break;
						case $red:
							$this->addToTeam($player, "red");
							return true;
							break;
						case $green:
							$this->addToTeam($player, "green");
							return true;
							break;
						case $yellow:
							$this->addToTeam($player, "yellow");
							return true;
							break;
						default:
							$this->joinWorld($player, $waitworld);
							return true;
							break;
					}
				}
			}
		} 
		
		//////Functions
		public function getArenaName(){
			return $this->arenaname;
		}
		
		public function addToTeam(Player $player, $team){
			$name = $player->getName();
			switch(strtolower($team)){
				case "blue":
					if($this->checkIfTeamFull($team)){
						array_push($this->blue, $name);
						array_push($this->players, $name);
						$player->setNameTag(TextFormat::BLUE . $name); 
						$player->setDisplayName(TextFormat::BLUE . $name);
						$player->sendMessage(TextFormat::BLUE . "You joined the blue team!");
					}else{
						$player->sendMessage(TextFormat::RED . "Sorry, the blue team is full!");
					}
					break;
				case "red":
					if($this->checkIfTeamFull($team)){
						array_push($this->red, $name);
						array_push($this->players, $name);
						$player->setNameTag(TextFormat::BLUE . $name); 
						$player->setDisplayName(TextFormat::BLUE . $name);
						$player->sendMessage(TextFormat::BLUE . "You joined the red team!");
					}else{
						$player->sendMessage(TextFormat::RED . "Sorry, the red team is full!");
					}
					break;
				case "green":
					if($this->checkIfTeamFull($team)){
						array_push($this->green, $name);
						array_push($this->players, $name);
						$player->setNameTag(TextFormat::BLUE . $name); 
						$player->setDisplayName(TextFormat::BLUE . $name);
						$player->sendMessage(TextFormat::BLUE . "You joined the green team!");
					}else{
						$player->sendMessage(TextFormat::RED . "Sorry, the green team is full!");
					}
					break;
				case "yellow":
					if($this->checkIfTeamFull($team)){
						array_push($this->yellow, $name);
						array_push($this->players, $name);
						$player->setNameTag(TextFormat::YELLOW . $name); 
						$player->setDisplayName(TextFormat::YELLOW . $name);
						$player->sendMessage(TextFormat::YELLOW . "You joined the yellow team!");
					}else{
						$player->sendMessage(TextFormat::RED . "Sorry, the yellow team is full!");
					}
					break;
			}
		}
		
		public function checkIfTeamFull($team){
			switch($team){
				case "blue":
					if(count($this->blue) >= $this->plugin->setting->get("max_player_per_team")){
						return true;
					}else{
						return false;
					}
					break;
				case "red":
					if(count($this->red) >= $this->plugin->setting->get("max_player_per_team")){
						return true;
					}else{
						return false;
					}
					break;
				case "green":
					if(count($this->green) >= $this->plugin->setting->get("max_player_per_team")){
						return true;
					}else{
						return false;
					}
					break;
				case "yellow":
					if(count($this->yellow) >= $this->plugin->setting->get("max_player_per_team")){
						return true;
					}else{
						return false;
					}
					break;
			}
		}
		
		public function getTeam(Player $player){
			$name = $player->getName();
			if(in_array($name, $this->players){
				if(in_array($name, $this->blue)){
					return "blue";
				}elseif(in_array($name, $this->red)){
					return "red";
				}elseif(in_array($name, $this->green)){
					return "green";
				}elseif(in_array($name, $this->yellow)){
					return "yellow";
				}
			}
		}
		
		public function checkIfMatchFull(){
			if(count($this->players) >= $this->plugin->setting->get("max_player_per_team") * 4){
				return true;
			}else{
				return false;
			}
		}
}
