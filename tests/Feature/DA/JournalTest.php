<?php

namespace Tests\Feature\DA;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class JournalTest extends TestCase
{
    public function test_double_entry_invariant_per_journal(): void
    {
        // Seed minimal accounts
        $cashAccountId = DB::connection('tenant')->table('accounts')->insertGetId([
            'title' => 'Cash',
            'root_type' => 1, // Asset
            'account_type_id' => 1,
            'accountable_type' => 1,
            'accountable_id' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $equityAccountId = DB::connection('tenant')->table('accounts')->insertGetId([
            'title' => "Owner's Equity",
            'root_type' => 5, // Capital/Equity
            'account_type_id' => 1,
            'accountable_type' => 1,
            'accountable_id' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create debit and credit transactions
        $amount = 1000.00;
        $debitTxnId = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $cashAccountId,
            'date' => now()->toDateString(),
            'amount' => $amount,
            'debit' => $amount,
            'credit' => 0,
            'type' => 'DEBIT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $creditTxnId = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $equityAccountId,
            'date' => now()->toDateString(),
            'amount' => $amount,
            'debit' => 0,
            'credit' => $amount,
            'type' => 'CREDIT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Link them via de_journals
        $journalId = DB::connection('tenant')->table('de_journals')->insertGetId([
            'debit_transaction_id' => $debitTxnId,
            'credit_transaction_id' => $creditTxnId,
            'amount' => $amount,
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertNotNull($journalId);

        // Invariant: sum(debits) == sum(credits) for this journal
        $debit = (float) DB::connection('tenant')->table('account_transactions')->where('id', $debitTxnId)->value('debit');
        $credit = (float) DB::connection('tenant')->table('account_transactions')->where('id', $creditTxnId)->value('credit');
        $this->assertSame($debit, $credit);
    }
}

