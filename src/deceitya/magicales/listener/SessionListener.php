<?php

declare(strict_types=1);

namespace deceitya\magicales\listener;

use deceitya\magicales\session\Phase;
use deceitya\magicales\session\Session;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\Player;

class SessionListener implements Listener
{
    /** @var Session */
    private $session;

    /**
     * pvpOnじゃなかったらキャンセル
     *
     * @param EntityDamageEvent $event
     * @return void
     */
    public function onEntityDamage(EntityDamageEvent $event)
    {
        $entity = $event->getEntity();
        if ($this->session->getPhase() !== Phase::PHASE_INGAME && $entity instanceof Player) {
            $event->setCancelled();
        }
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }
}
