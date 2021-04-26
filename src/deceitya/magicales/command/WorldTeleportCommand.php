<?php

declare(strict_types=1);

namespace deceitya\magicales\command;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use deceitya\magicales\Main;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class WorldTeleportCommand extends BaseCommand
{
    protected function prepare(): void
    {
        $this->setPermission('magicales.command.worldtp');
        $this->registerArgument(0, new RawStringArgument('world'));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!($sender instanceof Player)) {
            $sender->sendMessage(TextFormat::RED . 'You can only perform this command as a player');
            return;
        }

        $level = $sender->getServer()->getLevelByName($args['world']);
        if ($sender->getServer()->loadLevel($args['world'])) {
            $sender->teleport($sender->getServer()->getLevelByName($args['world'])->getSafeSpawn());
            $sender->sendMessage(Main::getInstance()->getLanguage()->translateString('command.worldtp.world_not_found', [$args['world']]));
        } else {
            $sender->sendMessage(Main::getInstance()->getLanguage()->translateString('command.worldtp.world_not_found', [$args['world']]));
        }
    }
}
