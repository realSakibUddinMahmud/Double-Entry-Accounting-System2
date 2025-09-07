<?php

namespace Tests\Feature\DA;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ReversalTest extends TestCase
{
    public function test_reversal_negates_original(): void
    {
        $cash = DB::connection('tenant')->table('accounts')->insertGetId([
            'title' => 'Cash', 'root_type' => 1, 'account_type_id' => 1,
            'accountable_type' => 1, 'accountable_id' => 0,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $expense = DB::connection('tenant')->table('accounts')->insertGetId([
            'title' => 'Expense', 'root_type' => 2, 'account_type_id' => 7,
            'accountable_type' => 1, 'accountable_id' => 0,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $amount = 100.00;
        // Original: DR Expense, CR Cash
        $dr = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $expense, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => $amount, 'credit' => 0, 'type' => 'DEBIT',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $cr = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $cash, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => 0, 'credit' => $amount, 'type' => 'CREDIT',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::connection('tenant')->table('de_journals')->insert([
            'debit_transaction_id' => $dr, 'credit_transaction_id' => $cr, 'amount' => $amount,
            'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now(),
        ]);

        // Reversal: DR Cash, CR Expense
        $rdr = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $cash, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => $amount, 'credit' => 0, 'type' => 'DEBIT',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $rcr = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $expense, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => 0, 'credit' => $amount, 'type' => 'CREDIT',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::connection('tenant')->table('de_journals')->insert([
            'debit_transaction_id' => $rdr, 'credit_transaction_id' => $rcr, 'amount' => $amount,
            'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now(),
        ]);

        $cashBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('credit');
        $expenseBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $expense)->sum('debit')
                    - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $expense)->sum('credit');

        $this->assertSame(0.00, round($cashBal, 2));
        $this->assertSame(0.00, round($expenseBal, 2));
    }
}

