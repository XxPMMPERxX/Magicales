<?php

declare(strict_types=1);

namespace deceitya\magicales\session;

use deceitya\magicales\Main;
use Generator;
use pocketmine\Server;

class Session
{
    /** @var int */
    private static $counter = 0;

    /**
     * 新しいセッションを作成する
     *
     * @return Session
     */
    public static function createSession(): Session
    {
        return new Session(new SessionId(self::$counter++));
    }
    
    /** @var SessionId */
    private $id;
    /** @var Phase */
    private $phase;
    /** @var string[] */
    private $players = [];

    private function __construct(SessionId $id)
    {
        $this->id = $id;
    }

    public function getId(): SessionId
    {
        return $this->id;
    }

    public function getPhase(): Phase
    {
        return $this->phase;
    }

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

    /**
     * 試合のフロー
     *
     * @return Generator
     */
    public function next(): Generator
    {
        $this->startRecruiting();
        yield;

        $this->startPrepare();
        yield;
    }

    private function startRecruiting()
    {
        $this->phase = new Phase(Phase::PHASE_RECRUITMENT);
        Server::getInstance()->broadcastMessage(Main::getInstance()->getLanguage()->get('session.start_recruit'));
    }

    private function startPrepare()
    {
        $this->phase = new Phase(Phase::PHASE_PREPARE);
    }
}
