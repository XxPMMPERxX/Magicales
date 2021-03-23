<?php

declare(strict_types=1);

namespace deceitya\magicales\item;

use deceitya\magicales\Main;
use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\Player;

class XxDarknessBurstxX extends Item implements IItem
{
    public function __construct()
    {
        parent::__construct(ItemIds::BLAZE_POWDER, 0, 'XxDarknessBurstxX');
    }

    public function getCost(): int
    {
        return 40;
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

        $players = array_filter($player->level->getPlayers(), function ($p) use ($player) {
            return $player !== $p && $player->distance($p) < 10;
        });
        foreach ($players as $p) {
            $p->setOnFire(10);
            $p->sendMessage(Main::getInstance()->getLanguage()->get('item.darkness_burst.damaged'));
        }
    }
}
