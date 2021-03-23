<?php

declare(strict_types=1);

namespace deceitya\magicales\listener;

use deceitya\magicales\item\IItem;
use deceitya\magicales\Main;
use deceitya\magicales\MPlayer;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

class MagicPointListener implements Listener
{
    public function onInteract(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if ($item instanceof IItem && $player instanceof MPlayer) {
            if ($item->getCost() <= $player->mp->getValue()) {
                $player->decreaseMagicPoint($item->getCost());
            } else {
                $event->setCancelled(true);
                $player->sendTip(Main::getInstance()->getLanguage()->get('magic_point.not_enough'));
            }
        }
    }
}
