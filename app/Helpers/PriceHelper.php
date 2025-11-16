<?php

namespace App\Helpers;

class PriceHelper
{
    /**
     * Format price for display with 2 decimal places
     * 
     * @param float|string $price
     * @param bool $showDecimals Show decimal places (default: false for BDT)
     * @return string
     */
    public static function format($price, $showDecimals = false): string
    {
        $price = is_string($price) ? (float)$price : $price;
        
        if ($showDecimals) {
            return number_format($price, 2, '.', ',');
        }
        
        // For BDT, round to nearest integer for display
        return number_format(round($price), 0, '.', ',');
    }

    /**
     * Format price with currency symbol
     * 
     * @param float|string $price
     * @param bool $showDecimals
     * @return string
     */
    public static function formatWithCurrency($price, $showDecimals = false): string
    {
        return '৳' . self::format($price, $showDecimals);
    }

    /**
     * Calculate total price with precision using bcmath
     * 
     * @param float|string $unitPrice
     * @param int $quantity
     * @return string
     */
    public static function calculateTotal($unitPrice, $quantity): string
    {
        return bcmul((string)$unitPrice, (string)$quantity, 2);
    }

    /**
     * Add two prices with precision using bcmath
     * 
     * @param float|string $price1
     * @param float|string $price2
     * @return string
     */
    public static function add($price1, $price2): string
    {
        return bcadd((string)$price1, (string)$price2, 2);
    }

    /**
     * Subtract two prices with precision using bcmath
     * 
     * @param float|string $price1
     * @param float|string $price2
     * @return string
     */
    public static function subtract($price1, $price2): string
    {
        return bcsub((string)$price1, (string)$price2, 2);
    }
}

