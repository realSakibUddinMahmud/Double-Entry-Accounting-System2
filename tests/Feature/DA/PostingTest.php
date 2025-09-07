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

    public function test_sales_return_cash(): void
    {
        $saleAmount = 200.00;
        $cogsAmount = 120.00;

        $cash = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Cash', 'root_type' => 1, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);
        $sales = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Sales', 'root_type' => 4, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);
        $inventory = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Inventory', 'root_type' => 1, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);
        $cogs = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'COGS', 'root_type' => 2, 'account_type_id' => 7, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);

        // Return: reverse sale (DR Sales, CR Cash)
        $drSales = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $sales, 'date' => now()->toDateString(), 'amount' => $saleAmount, 'debit' => $saleAmount, 'credit' => 0, 'type' => 'DEBIT', 'created_at' => now(), 'updated_at' => now()]);
        $crCash = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $cash, 'date' => now()->toDateString(), 'amount' => $saleAmount, 'debit' => 0, 'credit' => $saleAmount, 'type' => 'CREDIT', 'created_at' => now(), 'updated_at' => now()]);
        DB::connection('tenant')->table('de_journals')->insert(['debit_transaction_id' => $drSales, 'credit_transaction_id' => $crCash, 'amount' => $saleAmount, 'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now()]);

        // Return COGS reversal: DR Inventory, CR COGS
        $drInv = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $inventory, 'date' => now()->toDateString(), 'amount' => $cogsAmount, 'debit' => $cogsAmount, 'credit' => 0, 'type' => 'DEBIT', 'created_at' => now(), 'updated_at' => now()]);
        $crCogs = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $cogs, 'date' => now()->toDateString(), 'amount' => $cogsAmount, 'debit' => 0, 'credit' => $cogsAmount, 'type' => 'CREDIT', 'created_at' => now(), 'updated_at' => now()]);
        DB::connection('tenant')->table('de_journals')->insert(['debit_transaction_id' => $drInv, 'credit_transaction_id' => $crCogs, 'amount' => $cogsAmount, 'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now()]);

        $cashBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('credit');
        $salesBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $sales)->sum('credit')
                  - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $sales)->sum('debit');
        $inventoryBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $inventory)->sum('debit')
                      - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $inventory)->sum('credit');
        $cogsBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cogs)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cogs)->sum('credit');

        $this->assertSame(round(-$saleAmount, 2), round($cashBal, 2));
        $this->assertSame(round(-$saleAmount, 2), round($salesBal, 2));
        $this->assertSame(round($cogsAmount, 2), round($inventoryBal, 2));
        $this->assertSame(round(-$cogsAmount, 2), round($cogsBal, 2));
    }

    /**
     * @dataProvider \Tests\Support\DataProviders\AccountingDataProviders::transfers
     */
    public function test_fund_transfer(float $amount): void
    {
        $cashA = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Cash A', 'root_type' => 1, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);
        $cashB = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Cash B', 'root_type' => 1, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);

        $drB = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $cashB, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => $amount, 'credit' => 0, 'type' => 'DEBIT', 'created_at' => now(), 'updated_at' => now()]);
        $crA = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $cashA, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => 0, 'credit' => $amount, 'type' => 'CREDIT', 'created_at' => now(), 'updated_at' => now()]);
        DB::connection('tenant')->table('de_journals')->insert(['debit_transaction_id' => $drB, 'credit_transaction_id' => $crA, 'amount' => $amount, 'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now()]);

        $aBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cashA)->sum('debit')
               - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cashA)->sum('credit');
        $bBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cashB)->sum('debit')
               - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cashB)->sum('credit');

        $this->assertSame(round(-$amount, 2), round($aBal, 2));
        $this->assertSame(round($amount, 2), round($bBal, 2));
    }

    /**
     * @dataProvider \Tests\Support\DataProviders\AccountingDataProviders::drawings
     */
    public function test_owner_drawings(float $amount): void
    {
        $drawings = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Drawings', 'root_type' => 5, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);
        $cash = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Cash', 'root_type' => 1, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);

        $dr = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $drawings, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => $amount, 'credit' => 0, 'type' => 'DEBIT', 'created_at' => now(), 'updated_at' => now()]);
        $cr = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $cash, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => 0, 'credit' => $amount, 'type' => 'CREDIT', 'created_at' => now(), 'updated_at' => now()]);
        DB::connection('tenant')->table('de_journals')->insert(['debit_transaction_id' => $dr, 'credit_transaction_id' => $cr, 'amount' => $amount, 'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now()]);

        $drawBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $drawings)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $drawings)->sum('credit');
        $cashBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('credit');

        $this->assertSame(round($amount, 2), round($drawBal, 2));
        $this->assertSame(round(-$amount, 2), round($cashBal, 2));
    }

    /**
     * @dataProvider \Tests\Support\DataProviders\AccountingDataProviders::ppeAcquisitions
     */
    public function test_ppe_acquisition(float $amount): void
    {
        $ppe = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'PPE', 'root_type' => 1, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);
        $cash = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Cash', 'root_type' => 1, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);

        $dr = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $ppe, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => $amount, 'credit' => 0, 'type' => 'DEBIT', 'created_at' => now(), 'updated_at' => now()]);
        $cr = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $cash, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => 0, 'credit' => $amount, 'type' => 'CREDIT', 'created_at' => now(), 'updated_at' => now()]);
        DB::connection('tenant')->table('de_journals')->insert(['debit_transaction_id' => $dr, 'credit_transaction_id' => $cr, 'amount' => $amount, 'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now()]);

        $ppeBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $ppe)->sum('debit')
                - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $ppe)->sum('credit');
        $cashBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('credit');

        $this->assertSame(round($amount, 2), round($ppeBal, 2));
        $this->assertSame(round(-$amount, 2), round($cashBal, 2));
    }

    /**
     * @dataProvider \Tests\Support\DataProviders\AccountingDataProviders::otherIncome
     */
    public function test_other_income(float $amount): void
    {
        $cash = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Cash', 'root_type' => 1, 'account_type_id' => 1, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);
        $income = DB::connection('tenant')->table('accounts')->insertGetId(['title' => 'Other Income', 'root_type' => 4, 'account_type_id' => 8, 'accountable_type' => 1, 'accountable_id' => 0, 'created_at' => now(), 'updated_at' => now()]);

        $dr = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $cash, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => $amount, 'credit' => 0, 'type' => 'DEBIT', 'created_at' => now(), 'updated_at' => now()]);
        $cr = DB::connection('tenant')->table('account_transactions')->insertGetId(['account_id' => $income, 'date' => now()->toDateString(), 'amount' => $amount, 'debit' => 0, 'credit' => $amount, 'type' => 'CREDIT', 'created_at' => now(), 'updated_at' => now()]);
        DB::connection('tenant')->table('de_journals')->insert(['debit_transaction_id' => $dr, 'credit_transaction_id' => $cr, 'amount' => $amount, 'date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now()]);

        $cashBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('debit')
                 - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $cash)->sum('credit');
        $incomeBal = (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $income)->sum('credit')
                   - (float) DB::connection('tenant')->table('account_transactions')->where('account_id', $income)->sum('debit');

        $this->assertSame(round($amount, 2), round($cashBal, 2));
        $this->assertSame(round($amount, 2), round($incomeBal, 2));
    }
}
 
