<?php

declare(strict_types=1);

namespace deceitya\magicales\command;

use CortexPE\Commando\BaseSubCommand;
use deceitya\magicales\Main;
use pocketmine\command\CommandSender;

class SessionNextCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
        $this->setPermission('magicales.command.session.next');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $plugin = Main::getInstance();
        $plugin->getSession()->next();
        $sender->sendMessage($plugin->getLanguage()->get('command.session.next'));
    }
}
