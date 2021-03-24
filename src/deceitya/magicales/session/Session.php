<?php

declare(strict_types=1);

namespace deceitya\magicales\session;

use deceitya\magicales\event\session\SessionPhaseSwitchEvent;
use RuntimeException;

class Session
{
    /** @var Phase */
    public $phase;
    /** @var string[] */
    private $players = [];

    /**
     * プレイヤーを追加する
     *
     * @param string $player
     * @return boolean
     */
    public function addPlayer(string $player): bool
    {
        if ($this->isPlayerJoined($player)) {
            return false;
        }
        
        $this->phase = new Phase(Phase::PHASE_VOID);
        $this->players[] = $player;
        return true;
    }

    /**
     * $playerが参加しているか
     *
     * @param string $player
     * @return boolean
     */
    public function isPlayerJoined(string $player): bool
    {
        return in_array($player, $this->players, true);
    }

    /**
     * $playerをキック
     *
     * @param string $player
     * @return boolean
     */
    public function kickPlayer(string $player): bool
    {
        if ($this->isPlayerJoined($player)) {
            array_values(array_diff($this->players, [$player]));
            return true;
        }
        return false;
    }

    public function nextPhase(): bool
    {
        try {
            $this->phase = $this->phase->next();
            (new SessionPhaseSwitchEvent($this))->call();

            return true;
        } catch (RuntimeException $e) {
            return false;
        }
    }
}
