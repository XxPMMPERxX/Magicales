<?php

declare(strict_types=1);

namespace deceitya\magicales\command;

use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class IDCommand extends BaseCommand
{
    protected function prepare(): void
    {
        $this->setPermission('magicales.command.id');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!($sender instanceof Player)) {
            $sender->sendMessage(TextFormat::RED . 'You can only perform this command as a player');
            return;
        }

        $item = $sender->getInventory()->getItemInHand();
        $sender->sendMessage("{$item->getId()} : {$item->getDamage()}");
    }
}
