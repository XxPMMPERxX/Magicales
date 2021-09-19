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
        $main = Main::getInstance();
        $main->nextSession();
        $session = $main->getSession();
        $sender->sendMessage($main->getLanguage()->translateString('command.session.new', [$session->getId()->getValue()]));
    }
}
