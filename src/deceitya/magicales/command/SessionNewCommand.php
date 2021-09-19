<?php

declare(strict_types=1);

namespace deceitya\magicales\command;

use CortexPE\Commando\BaseSubCommand;
use deceitya\magicales\Main;
use pocketmine\command\CommandSender;

class SessionNewCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
        $this->setPermission('magicales.command.session.new');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $plugin = Main::getInstance();
        $plugin->nextSession();
        $session = $plugin->getSession();
        $sender->sendMessage($plugin->getLanguage()->translateString('command.session.new', [$session->getId()->getValue()]));
    }
}
