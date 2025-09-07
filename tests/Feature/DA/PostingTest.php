<?php

namespace Tests\Feature\DA;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostingTest extends TestCase
{
    public function test_sales_posting_cash(): void
    {
        // Accounts
        $cash = DB::connection('tenant')->table('accounts')->insertGetId([
            'title' => 'Cash', 'root_type' => 1, 'account_type_id' => 1,
            'accountable_type' => 1, 'accountable_id' => 0,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $sales = DB::connection('tenant')->table('accounts')->insertGetId([
            'title' => 'Sales', 'root_type' => 4, 'account_type_id' => 1,
            'accountable_type' => 1, 'accountable_id' => 0,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $amount = 250.00;
        $debitTxn = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $cash, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => $amount, 'credit' => 0, 'type' => 'DEBIT',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $creditTxn = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $sales, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => 0, 'credit' => $amount, 'type' => 'CREDIT',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::connection('tenant')->table('de_journals')->insert([
            'debit_transaction_id' => $debitTxn,
            'credit_transaction_id' => $creditTxn,
            'amount' => $amount,
            'date' => now()->toDateString(),
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $cashBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('credit');
        $salesBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $sales)->sum('credit')
                  - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $sales)->sum('debit');

        $this->assertSame(250.00, round($cashBal, 2));
        $this->assertSame(250.00, round($salesBal, 2));
    }
}

