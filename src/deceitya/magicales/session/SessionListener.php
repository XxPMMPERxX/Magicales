<?php

declare(strict_types=1);

namespace deceitya\magicales\session;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\Player;

class SessionListener implements Listener
{
    /** @var bool */
    private $pvpOn = false;

    /**
     * pvpOnじゃなかったらキャンセル
     *
     * @param EntityDamageEvent $event
     * @return void
     */
    public function onEntityDamage(EntityDamageEvent $event)
    {
        $entity = $event->getEntity();
        if (!$this->pvpOn && $entity instanceof Player) {
            $event->setCancelled();
        }
    }

    public function setCanPvP(bool $value)
    {
        $this->pvpOn = $value;
    }
}
