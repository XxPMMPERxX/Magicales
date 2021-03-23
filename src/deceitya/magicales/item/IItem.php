<?php

declare(strict_types=1);

namespace deceitya\magicales\item;

interface IItem
{
    /**
     * 魔力
     *
     * @return integer
     */
    public function getCost(): int;

    /**
     * 実行
     *
     * @param [type] ...$args
     * @return void
     */
    public function execute(...$args);
}
