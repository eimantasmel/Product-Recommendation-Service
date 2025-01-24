<?php

namespace App\Constant;

class ConditionCodes
{
    public const SUNNY = 'clear';
    public const PARTLY_CLOUDY = 'partly-cloudy';
    public const CLOUDY = 'cloudy';
    public const OVERCAST = 'overcast';
    public const FOG = 'fog';
    public const LIGHT_RAIN = 'light-rain';
    public const MODERATE_RAIN = 'moderate-rain';
    public const HEAVY_RAIN = 'heavy-rain';
    public const SLEET = 'sleet';
    public const LIGHT_SNOW = 'light-snow';
    public const MODERATE_SNOW = 'moderate-snow';
    public const HEAVY_SNOW = 'heavy-snow';
    public const THUNDER = 'thunder';
    public const HAIL = 'hail';
    public const DRIZZLE = 'drizzle';

    public static function getAll(): array
    {
        return [
            self::SUNNY,
            self::PARTLY_CLOUDY,
            self::CLOUDY,
            self::OVERCAST,
            self::FOG,
            self::LIGHT_RAIN,
            self::MODERATE_RAIN,
            self::HEAVY_RAIN,
            self::SLEET,
            self::LIGHT_SNOW,
            self::MODERATE_SNOW,
            self::HEAVY_SNOW,
            self::THUNDER,
            self::HAIL,
            self::DRIZZLE,
        ];
    }
}
