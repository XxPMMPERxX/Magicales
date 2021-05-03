<?php

declare(strict_types=1);

namespace deceitya\magicales\item;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\Player;

class PartyTime extends Item implements IItem
{
    public function __construct()
    {
        parent::__construct(ItemIds::STRING, 0, 'PartyTime');
    }
    
    public function getCost(): int
    {
        return 1;
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

        for ($i = 60; $i <= 360; $i += 60) {
            $entity = Entity::createEntity(
                'Mirage',
                $player->level,
                Entity::createBaseNBT($player, null, $player->yaw + $i, $player->pitch),
                $player,
                $i
            );
            $entity->spawnToAll();
        }
    }
}
