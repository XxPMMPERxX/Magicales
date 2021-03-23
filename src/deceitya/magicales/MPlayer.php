<?php

declare(strict_types=1);

namespace deceitya\magicales;

use pocketmine\entity\Attribute;
use pocketmine\network\SourceInterface;
use pocketmine\Player;
use RuntimeException;

class MPlayer extends Player
{
    /** @var MagicPoint */
    private $mp;
    /** @var int */
    private $lastIncreaseTick = 0;

    public function __construct(SourceInterface $interface, string $ip, int $port)
    {
        parent::__construct($interface, $ip, $port);
        $this->mp = new MagicPoint(0);
    }

    public function onUpdate(int $currentTick): bool
    {
        if (!parent::onUpdate($currentTick)) {
            return false;
        }

        if ($currentTick - $this->lastIncreaseTick > 20) {
            $this->lastIncreaseTick = $currentTick;
            $this->increaseMagicPoint(1);
            $this->updateMagicPointBar();
        }

        return true;
    }

    /**
     * MPを回復する
     *
     * @param integer $amount
     * @return boolean
     */
    public function increaseMagicPoint(int $amount): bool
    {
        try {
            $this->mp = $this->mp->plus($amount);
            return true;
        } catch (RuntimeException $e) {
            return false;
        }
    }

    /**
     * MPを減らす
     *
     * @param integer $amount
     * @return boolean
     */
    public function decreaseMagicPoint(int $amount): bool
    {
        try {
            $this->mp = $this->mp->minus($amount);
            return true;
        } catch (RuntimeException $e) {
            return false;
        }
    }

    public function updateMagicPointBar(): void
    {
        $this->attributeMap->getAttribute(Attribute::EXPERIENCE)->setValue($this->mp->getValue() / 100);
        $this->attributeMap->getAttribute(Attribute::EXPERIENCE_LEVEL)->setValue($this->mp->getValue());
    }
}
