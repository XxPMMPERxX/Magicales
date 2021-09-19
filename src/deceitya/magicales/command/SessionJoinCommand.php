<?php

declare(strict_types=1);

namespace deceitya\magicales\command;

use CortexPE\Commando\BaseSubCommand;
use deceitya\magicales\Main;
use deceitya\magicales\session\Phase;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class SessionJoinCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
        $this->setPermission('magicales.command.session.join');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!($sender instanceof Player)) {
            $sender->sendMessage(TextFormat::RED . 'You can only perform this command as a player');
            return;
        }

        $session = Main::getInstance()->getSession()->getPhase() === Phase::PHASE_RECRUITMENT ? Main::getInstance()->getSession() : Main::getInstance()->getNextSession();
        $session->addPlayer($sender->getName());
        $sender->sendMessage($main->getLanguage()->translateString('command.session.join', [(string) $session->getId()->getValue()]));
    }
}
