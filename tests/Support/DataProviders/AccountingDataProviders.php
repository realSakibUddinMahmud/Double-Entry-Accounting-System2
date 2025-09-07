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
}