<?php

namespace App\Helpers;

class OutletHelper
{
    /**
     * Convert outlet distance into kilometers
     *
     * @param float $distance
     * @return string
     */
    public static function convertOutletDistance(float $distance): string
    {
        $roundedDistance = floor($distance * 10) / 10;
        return "$roundedDistance km";
    }
}
