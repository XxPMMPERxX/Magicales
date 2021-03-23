<?php

declare(strict_types=1);

namespace deceitya\magicales;

require_once(dirname(__FILE__, 4) . '/vendor/autoload.php');

use deceitya\magicales\command\IDCommand;
use deceitya\magicales\command\SummonCommand;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    /** @var Main */
    private static $instance;

    public static function getInstance(): Main
    {
        return self::$instance;
    }

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $this->getServer()->getCommandMap()->registerAll('Magicales', [
            new IDCommand($this, 'id', 'Get a id and damage of item in hand'),
            new SummonCommand($this, 'summon', 'Creates an entity at any given position')
        ]);
    }
}
