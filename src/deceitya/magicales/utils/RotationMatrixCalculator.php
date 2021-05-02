<?php

declare(strict_types=1);

namespace deceitya\magicales\utils;

use pocketmine\math\Vector3;

abstract class RotationMatrixCalculator
{
    public static function calcXRotate(Vector3 $v, float $degree): Vector3
    {
        $rad = deg2rad($degree);
        $r = [
            [1, 0, 0],
            [0, cos($rad), -sin($rad)],
            [0, sin($rad), cos($rad)]
        ];
        return new Vector3(
            $v->x,
            $v->y * $r[1][1] + $v->z * $r[1][2],
            $v->y * $r[2][1] + $v->z * $r[2][2]
        );
    }

    public static function calcYRotate(Vector3 $v, float $degree): Vector3
    {
        $rad = deg2rad($degree);
        $r = [
            [cos($rad), 0, sin($rad)],
            [0, 1, 0],
            [-sin($rad), 0, cos($rad)]
        ];
        return new Vector3(
            $v->x * $r[0][0] + $v->z * $r[0][2],
            $v->y,
            $v->x * $r[2][0] + $v->z * $r[2][2]
        );
    }

    public static function calcZRotate(Vector3 $v, float $degree): Vector3
    {
        $rad = deg2rad($degree);
        $r = [
            [cos($rad), -sin($rad), 0],
            [sin($rad), cos($rad), 0],
            [0, 0, 1]
        ];
        return new Vector3(
            $v->x *$r[0][0] + $v->y * $r[0][1],
            $v->x * $r[1][0] + $v->y * $r[1][1],
            $v->z
        );
    }
}
