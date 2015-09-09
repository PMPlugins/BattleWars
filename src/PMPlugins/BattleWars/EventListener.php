<?php

namespace PMPlugins\BattleWars;





use pocketmine\Player;

use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class EventListener implements Listener{
	
		public function __construct(Loader $plugin){
			$this->plugin = $plugin;
			$this->pureperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		}
	
 
}
