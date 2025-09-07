<?php

namespace Tests\Feature\DA;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostingTest extends TestCase
{
    /**
     * @dataProvider \Tests\Support\DataProviders\AccountingDataProviders::salesPostings
     */
    public function test_sales_posting_cash(float $amount): void
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

        $this->assertSame(round($amount, 2), round($cashBal, 2));
        $this->assertSame(round($amount, 2), round($salesBal, 2));
    }

    /**
     * @dataProvider \Tests\Support\DataProviders\AccountingDataProviders::purchaseAmounts
     */
    public function test_purchase_posting_cash(float $amount): void
    {
        // Accounts: Inventory (asset), Cash (asset)
        $inventory = DB::connection('tenant')->table('accounts')->insertGetId([
            'title' => 'Inventory', 'root_type' => 1, 'account_type_id' => 1,
            'accountable_type' => 1, 'accountable_id' => 0,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $cash = DB::connection('tenant')->table('accounts')->insertGetId([
            'title' => 'Cash', 'root_type' => 1, 'account_type_id' => 1,
            'accountable_type' => 1, 'accountable_id' => 0,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $dr = DB::connection('tenant')->table('account_transactions')->insertGetId([
            'account_id' => $inventory, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => $amount, 'credit' => 0, 'type' => 'DEBIT',
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

        $inventoryBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $inventory)->sum('debit')
                      - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $inventory)->sum('credit');
        $cashBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('credit');

        $this->assertSame(round($amount, 2), round($inventoryBal, 2));
        $this->assertSame(round(-$amount, 2), round($cashBal, 2));
    }

    /**
     * @dataProvider \Tests\Support\DataProviders\AccountingDataProviders::salesWithCogs
     */
    public function test_sales_with_cogs(float $saleAmount, float $cogsAmount): void
    {
        // Accounts: Cash (A), Sales (I), Inventory (A), COGS (E)
        $cash = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Cash', 'root_type' => 1, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);
        $sales = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Sales', 'root_type' => 4, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);
        $inventory = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Inventory', 'root_type' => 1, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);
        $cogs = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'COGS', 'root_type' => 2, 'account_type_id' => 7, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);

        // Sales: DR Cash, CR Sales
        $drSales = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $cash, 'date' => now()->toDateString(), 'amount' => $saleAmount, 'debit' => $saleAmount, 'credit' => 0, 'type' => 'DEBIT', 'created_at' => now(), 'updated_at' => now()]);
        $crSales = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $sales, 'date' => now()->toDateString(), 'amount' => $saleAmount, 'debit' => 0, 'credit' => $saleAmount, 'type' => 'CREDIT', 'created_at' => now(), 'updated_at' => now()]);
        DB::connection('tenant')->table('de_journals')->insert(['debit_transaction_id' => $drSales, 'credit_transaction_id' => $crSales, 'amount' => $saleAmount, 'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now()]);

        // COGS: DR COGS, CR Inventory
        $drCogs = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $cogs, 'date' => now()->toDateString(), 'amount' => $cogsAmount, 'debit' => $cogsAmount, 'credit' => 0, 'type' => 'DEBIT', 'created_at' => now(), 'updated_at' => now()]);
        $crInv = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $inventory, 'date' => now()->toDateString(), 'amount' => $cogsAmount, 'debit' => 0, 'credit' => $cogsAmount, 'type' => 'CREDIT', 'created_at' => now(), 'updated_at' => now()]);
        DB::connection('tenant')->table('de_journals')->insert(['debit_transaction_id' => $drCogs, 'credit_transaction_id' => $crInv, 'amount' => $cogsAmount, 'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now()]);

        // Assertions
        $cashBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('credit');
        $salesBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $sales)->sum('credit')
                  - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $sales)->sum('debit');
        $inventoryBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $inventory)->sum('debit')
                      - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $inventory)->sum('credit');
        $cogsBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cogs)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cogs)->sum('credit');

        $this->assertSame(round($saleAmount, 2), round($cashBal, 2));
        $this->assertSame(round($saleAmount, 2), round($salesBal, 2));
        $this->assertSame(round(-$cogsAmount, 2), round($inventoryBal, 2));
        $this->assertSame(round($cogsAmount, 2), round($cogsBal, 2));
    }
}
 
