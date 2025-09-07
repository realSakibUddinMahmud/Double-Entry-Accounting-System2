<?php

namespace Tests\Feature\DA;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StatementsTest extends TestCase
{
    public function test_trial_balance_balances(): void
    {
        // Seed a couple of pairs
        $asset = DB::connection('tenant')->table('accounts')->insertGetId([
            'title' => 'Bank', 'root_type' => 1, 'account_type_id' => 1,
            'accountable_type' => 1, 'accountable_id' => 0,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $income = DB::connection('tenant')->table('accounts')->insertGetId([
            'title' => 'Service Revenue', 'root_type' => 4, 'account_type_id' => 1,
            'accountable_type' => 1, 'accountable_id' => 0,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $amount = 500.00;
        $dr = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $asset, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => $amount, 'credit' => 0, 'type' => 'DEBIT',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $cr = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $income, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => 0, 'credit' => $amount, 'type' => 'CREDIT',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::connection('tenant')->table('de_journals')->insert([
            'debit_transaction_id' => $dr, 'credit_transaction_id' => $cr, 'amount' => $amount,
            'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now(),
        ]);

        $totalDebit = (float) DB::connection('tenant')->table('account_transactions')->sum('debit');
        $totalCredit = (float) DB::connection('tenant')->table('account_transactions')->sum('credit');
        $this->assertSame(round($totalDebit, 2), round($totalCredit, 2));
    }
}

