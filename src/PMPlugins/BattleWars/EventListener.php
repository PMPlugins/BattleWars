<?php

namespace PMPlugins\BattleWars;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
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

use pocketmine\Player;

use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

use PMPlugins\BattleWars\Loader;

class EventListener implements Listener{
	
		public function __construct(Loader $plugin){
			$this->plugin = $plugin;
			$this->pureperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		}
	
		public function onSignTap(PlayerInteractEvent $event){
			$player = $event->getPlayer();
			$name = $player->getName();
			$tile = $player->getLevel()->getTile($event->getBlock());
			$group = $this->pureperms->getUser($player)->getGroup()->getName();
			if($tile instanceof Sign){
				$text = $tile->getText();
			}
		}
}