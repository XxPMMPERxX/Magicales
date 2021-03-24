<?php

declare(strict_types=1);

namespace deceitya\magicales\event\session;

use deceitya\magicales\session\Session;
use pocketmine\event\Event;

abstract class SessionEvent extends Event
{
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getSession(): Session
    {
        return $this->session;
    }
}
