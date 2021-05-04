<?php

declare(strict_types=1);

namespace deceitya\magicales\entity;

use deceitya\magicales\utils\RotationMatrixCalculator;
use pocketmine\entity\Human;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class Mirage extends Human
{
    public const NETWORK_ID = 63;

    /** @var Player */
    private $owner;
    /** @var int */
    private $angle;

    /** @var Position */
    private $ownerLastPosition;

    public function __construct(Level $level, CompoundTag $tag, Player $owner, int $angle)
    {
        $tag->setTag($owner->namedtag->getCompoundTag('Skin'));
        parent::__construct($level, $tag);

        $this->owner = $owner;
        $this->angle = $angle;
        $this->ownerLastPosition = $this->owner->getPosition();
        
        $this->setMaxHealth(1);
        $this->setHealth(1);
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        $hasUpdate = parent::entityBaseTick($tickDiff);

        $motion = RotationMatrixCalculator::calcYRotate($this->owner->subtract($this->ownerLastPosition), $this->angle);
        $this->move($motion->x, $motion->y, $motion->z);
        $this->pitch = $this->owner->pitch;
        $this->yaw = ($this->owner->yaw - $this->angle) % 360;

        $this->setSneaking($this->owner->isSneaking());

        $this->ownerLastPosition = $this->owner->getPosition();
        
        return $hasUpdate;
    }
}
