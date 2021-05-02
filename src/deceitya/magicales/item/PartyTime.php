<?php

declare(strict_types=1);

namespace deceitya\magicales\item;

use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;

class PartyTime extends Item implements IItem
{
    public function getCost(): int
    {
        return 75;
    }

    public function onClickAir(Player $player, Vector3 $directionVector): bool
    {
        $this->execute($player);
        return true;
    }

    public function onActivate(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector): bool
    {
        $this->execute($player);
        return true;
    }

    public function execute(...$args)
    {
        $player = array_shift($args);
        if (!($player instanceof Player)) {
            return;
        }
    }
}
