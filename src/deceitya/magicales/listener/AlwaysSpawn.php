<?php

declare(strict_types=1);

namespace deceitya\magicales\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;

class AlwaysSpawn implements Listener
{
    public function onLogin(PlayerLoginEvent $event)
    {
        $player = $event->getPlayer();
        $player->teleport($player->getServer()->getDefaultLevel()->getSafeSpawn());
    }
}
