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
    /** @var Generator */
    private $flow;

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
        if ($this->phase->getValue() !== Phase::PHASE_RECRUITMENT || $this->isPlayerJoined($player)) {
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

    public function next()
    {
        if (!isset($this->flow)) {
            $this->flow = $this->flow();
        }

        $this->flow->next();
    }

    /**
     * Undocumented function
     *
     * @return Generator|Player[]
     */
    public function getPlayers(): Generator
    {
        foreach ($this->players as $player) {
            yield Server::getInstance()->getPlayer($player);
        }
    }

    /**
     * 試合のフロー
     *
     * @return Generator
     */
    private function flow(): Generator
    {
        $this->startRecruiting();
        yield;

        $this->startPrepare();
        yield;

        $this->startGame();
        yield;

        $this->finishGame();
        yield;
    }

    private function startRecruiting(): void
    {
        $this->phase = new Phase(Phase::PHASE_RECRUITMENT);
        Server::getInstance()->broadcastMessage(Main::getInstance()->getLanguage()->get('session.phase.recruit'));
    }

    private function startPrepare(): void
    {
        $this->phase = new Phase(Phase::PHASE_PREPARE);

        $server = Server::getInstance();
        $server->broadcastMessage(Main::getInstance()->getLanguage()->get('session.phase.prepare'));

        $pos = $server->getLevelByName('pvp')->getSafeSpawn();
        foreach ($this->getPlayers() as $player) {
            $player->teleport($pos);
        }
    }

    private function startGame(): void
    {
        $this->phase = new Phase(Phase::PHASE_INGAME);
        
        Server::getInstance()->broadcastMessage(Main::getInstance()->getLanguage()->get('session.phase.ingame'));
    }

    private function finishGame(): void
    {
        $this->phase = new Phase(Phase::PHASE_FINISHED);

        $server = Server::getInstance();
        $server->broadcastMessage(Main::getInstance()->getLanguage()->get('session.phase.finish'));

        $pos = $server->getDefaultLevel()->getSafeSpawn();
        foreach ($this->getPlayers() as $player) {
            $player->teleport($pos);
        }
    }
}
