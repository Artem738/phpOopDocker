<?php


namespace App\SmartCalculator\Enums;

enum ECalcOperations: string
{
    case ADD = 'add';
    case MULTIPLY = 'multiply';
    case MULTI = 'multi';
    case SUBTRACT = 'sub';
    case DIVIDE = 'divide';

    public static function allToString(): string
    {
        return implode(', ', array_column(self::cases(), 'value'));
    }
    public static function allToStringVertBar(): string
    {
        return implode('|', array_column(self::cases(), 'value'));
    }
}

