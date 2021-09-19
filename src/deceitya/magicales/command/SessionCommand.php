<?php

declare(strict_types=1);

namespace deceitya\magicales\command;

use CortexPE\Commando\BaseCommand;
use deceitya\magicales\Main;
use pocketmine\command\CommandSender;

class SessionCommand extends BaseCommand
{
    protected function prepare(): void
    {
        $this->setPermission('magicales.command.session');
        $this->registerSubCommand(new SessionNewCommand('new', Main::getInstance()->getLanguage()->get('command.session.new.description')));
        $this->registerSubCommand(new SessionNextCommand('next', Main::getInstance()->getLanguage()->get('command.session.next.description')));
        $this->registerSubCommand(new SessionJoinCommand('join', Main::getInstance()->getLanguage()->get('command.session.join.description')));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
    }
}
