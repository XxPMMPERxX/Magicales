<?php

declare(strict_types=1);

namespace deceitya\magicales;

require_once(dirname(__FILE__, 4) . '/vendor/autoload.php');

use deceitya\magicales\command\IDCommand;
use deceitya\magicales\command\SessionCommand;
use deceitya\magicales\command\SummonCommand;
use deceitya\magicales\command\WorldTeleportCommand;
use deceitya\magicales\entity\Mirage;
use deceitya\magicales\item\PartyTime;
use deceitya\magicales\item\XxDarknessBurstxX;
use deceitya\magicales\listener\AlwaysSpawn;
use deceitya\magicales\listener\MagicPointListener;
use deceitya\magicales\session\Session;
use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\item\ItemFactory;
use pocketmine\lang\BaseLang;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    /** @var Main */
    private static $instance;

    public static function getInstance(): Main
    {
        return self::$instance;
    }

    /** @var BaseLang */
    private $lang;
    /** @var Session */
    private $session;
    /** @var Session */
    private $nextSession;

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $this->lang = new BaseLang('jpn', $this->getFile() . 'resources' . DIRECTORY_SEPARATOR, 'jpn');
        $this->getServer()->getCommandMap()->registerAll('Magicales', [
            new IDCommand($this, 'id', $this->lang->get('command.id.description')),
            new SummonCommand($this, 'summon', $this->lang->get('command.summon.description')),
            new SessionCommand($this, 'session', $this->lang->get('command.session.description')),
            new WorldTeleportCommand($this, 'worldtp', $this->lang->get('command.worldtp.description'), ['wtp'])
        ]);

        Entity::registerEntity(Mirage::class, false, ['Mirage']);

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new MagicPointListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new AlwaysSpawn(), $this);

        ItemFactory::registerItem(new XxDarknessBurstxX(), true);
        ItemFactory::registerItem(new PartyTime(), true);
    }

    public function onDisable()
    {
        foreach ($this->getServer()->getLevels() as $level) {
            foreach ($level->getEntities() as $entity) {
                if (!($entity instanceof Player)) {
                    $entity->close();
                }
            }
        }
    }

    /**
     * メッセージのアレを返す
     *
     * @return BaseLang
     */
    public function getLanguage(): BaseLang
    {
        return $this->lang;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function getNextSession(): Session
    {
        return $this->nextSession;
    }

    public function nextSession(): void
    {
        $this->session = $this->nextSession === null ? Session::createSession() : $this->nextSession;
        $this->nextSession = Session::createSession();
    }

    public function onPlayerCreation(PlayerCreationEvent $event)
    {
        $event->setPlayerClass(MPlayer::class);
    }
}
