<?php

namespace Tests\Support\DataProviders;

class AccountingDataProviders
{
    public static function salesPostings(): array
    {
        return [
            'cash sale 250' => [250.00],
            'cash sale 0.01' => [0.01],
            'cash sale 999999.99' => [999999.99],
        ];
    }

    public static function expenseReversals(): array
    {
        return [
            'expense 100' => [100.00],
            'expense 1.23' => [1.23],
        ];
    }

    public static function purchaseAmounts(): array
    {
        return [
            'purchase 50' => [50.00],
            'purchase 123.45' => [123.45],
        ];
    }

    public static function salesWithCogs(): array
    {
        return [
            'sale 200 cogs 120' => [200.00, 120.00],
            'sale 15.55 cogs 9.99' => [15.55, 9.99],
        ];
    }

    public static function transfers(): array
    {
        return [
            'transfer 75' => [75.00],
            'transfer 0.50' => [0.50],
        ];
    }

    public static function drawings(): array
    {
        return [
            'draw 40' => [40.00],
            'draw 7.77' => [7.77],
        ];
    }

    public static function ppeAcquisitions(): array
    {
        return [
            'ppe 1000' => [1000.00],
            'ppe 0.75' => [0.75],
        ];
    }

    public static function otherIncome(): array
    {
        return [
            'other income 33' => [33.00],
            'other income 0.99' => [0.99],
        ];
    }
}