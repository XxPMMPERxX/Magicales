<?php

declare(strict_types=1);

namespace deceitya\magicales\entity;

use pocketmine\entity\Human;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class PlayerClone extends Human
{
    /** @var Player */
    private $owner;

    public function __construct(Level $level, CompoundTag $tag, Player $owner)
    {
        $tag->setTag($owner->namedtag->getCompoundTag('Skin'));
        parent::__construct($level, $tag);

        $this->owner = $owner;
    }

    public function onUpdate(int $currentTick): bool
    {
        if (!parent::onUpdate($currentTick)) {
            return false;
        }

        $this->setMotion($this->owner->lastMotion);
    }
}
