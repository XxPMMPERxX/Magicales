<?php

declare(strict_types=1);

namespace deceitya\magicales\utils;

use pocketmine\math\Vector3;

abstract class RotationMatrixCalculator
{
    public static function calcXRotate(Vector3 $v, float $degree): Vector3
    {
        $rad = deg2rad($degree);
        $cos = cos($rad);
        $sin = sin($rad);
        return new Vector3(
            $v->x,
            $v->y * $cos - $v->z * $sin,
            $v->y * $sin + $v->z * $cos
        );
    }

    public static function calcYRotate(Vector3 $v, float $degree): Vector3
    {
        $rad = deg2rad($degree);
        $cos = cos($rad);
        $sin = sin($rad);
        return new Vector3(
            $v->z * $sin + $v->x * $cos,
            $v->y,
            $v->z * $cos - $v->x * $sin
        );
    }

    public static function calcZRotate(Vector3 $v, float $degree): Vector3
    {
        $rad = deg2rad($degree);
        $cos = cos($rad);
        $sin = sin($rad);
        return new Vector3(
            $v->x * $cos - $v->y * $sin,
            $v->x * $sin + $v->y * $cos,
            $v->z
        );
    }
}
