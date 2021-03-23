<?php

declare(strict_types=1);

namespace deceitya\magicales;

require_once(dirname(__FILE__, 4) . '/vendor/autoload.php');

use deceitya\magicales\command\IDCommand;
use deceitya\magicales\command\SummonCommand;
use deceitya\magicales\item\XxDarknessBurstxX;
use deceitya\magicales\listener\MagicPointListener;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\item\ItemFactory;
use pocketmine\lang\BaseLang;
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

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $this->lang = new BaseLang('jpn', $this->getFile() . 'resources' . DIRECTORY_SEPARATOR, 'jpn');
        $this->getServer()->getCommandMap()->registerAll('Magicales', [
            new IDCommand($this, 'id', $this->lang->get('command.id.description')),
            new SummonCommand($this, 'summon', $this->lang->get('command.summon.description'))
        ]);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new MagicPointListener(), $this);
        ItemFactory::registerItem((new XxDarknessBurstxX()), true);
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

    public function onPlayerCreation(PlayerCreationEvent $event)
    {
        $event->setPlayerClass(MPlayer::class);
    }
}
