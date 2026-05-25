<?php

namespace App\Support;

class ProductFieldFormat
{
    public static function normalizeDecimal(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        $clean = preg_replace('/[^0-9.\-]/', '', (string) $value);

        return $clean === '' || $clean === '-' ? '' : $clean;
    }

    public static function formatMoney(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '—';
        }

        $num = (float) self::normalizeDecimal($value);

        return '$'.number_format($num, 2, '.', ',');
    }

    public static function formatWeight(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '—';
        }

        $num = (float) self::normalizeDecimal($value);

        return rtrim(rtrim(number_format($num, 2, '.', ''), '0'), '.').' lbs';
    }
}
