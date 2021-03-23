<?php

declare(strict_types=1);

namespace deceitya\magicales\command;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\args\Vector3Argument;
use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class SummonCommand extends BaseCommand
{
    protected function prepare(): void
    {
        $this->setPermission('magicales.command.summon');
        $this->registerArgument(0, new RawStringArgument('entityName'));
        $this->registerArgument(1, new Vector3Argument('spawnPos', true));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!($sender instanceof Player)) {
            $sender->sendMessage(TextFormat::RED . 'You can only perform this command as a player');
            return;
        }

        $entity = Entity::createEntity($args['entityName'], $sender->level, Entity::createBaseNBT($args['spawnPos'] ?? $sender));
        if ($entity !== null) {
            $entity->spawnToAll();
        } else {
            $sender->sendMessage("{$args['entityName']} was not found");
        }
    }
}
