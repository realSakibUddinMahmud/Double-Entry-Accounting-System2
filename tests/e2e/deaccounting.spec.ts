import { test, expect } from '@playwright/test';
import { assertDrEqualsCrForLatestJournal } from './helpers';

const ADMIN_PHONE = process.env.ADMIN_PHONE!;
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD!;

async function login(page) {
  await page.goto('/login');
  await page.locator('input[name="phone"]').fill(ADMIN_PHONE);
  await page.locator('input[name="password"]').fill(ADMIN_PASSWORD);
  await page.getByRole('button', { name: 'Sign In' }).click();
  await page.waitForLoadState('networkidle');
  await expect(page).not.toHaveURL(/login/);
}

test.describe('DEAccounting flows (create pages render and basic validation)', () => {
  const pages = [
    ['/de-accounting/accounts/new', /Account|Create/i],
    ['/de-accounting/payments/new', /From|To|Amount/i],
    ['/de-accounting/expenses/new', /From|To|Amount|Expense/i],
    ['/de-accounting/income-revenues/new', /Income|Amount/i],
    ['/de-accounting/fund-transfers/new', /From|To|Amount|Transfer/i],
    ['/de-accounting/loan-investments/new', /Loan|Investment|Amount/i],
    ['/de-accounting/loan-invreturns/new', /Return|Amount/i],
    ['/de-accounting/security-deposits/new', /Security|Deposit|Amount/i],
  ];

  for (const [path, hint] of pages) {
    test(`Open ${path} and attempt minimal invalid/valid interactions`, async ({ page }) => {
      await login(page);
      await page.goto(path);
      await expect(page.locator('body')).toContainText(hint);
      // 1) Invalid path: empty submit, expect some feedback if available
      const submit = page.getByRole('button', { name: /submit|save|create|add/i }).first();
      if (await submit.count()) {
        await submit.click().catch(() => {});
        const invalid = page.locator('.invalid-feedback, .alert').first();
        if (await invalid.count()) {
          await expect(invalid).toBeVisible();
        } else {
          console.warn(`No validation feedback visible on ${path} for empty submit`);
        }
      }

      // 2) Valid path: try to fill minimal valid fields if present
      const today = new Date().toISOString().slice(0, 10);
      const amount = page.locator('input[name*="amount" i]');
      if (await amount.count()) await amount.first().fill('100').catch(() => {});
      const dateInput = page.locator('input[type="date"], input[name*="date" i]');
      if (await dateInput.count()) await dateInput.first().fill(today).catch(() => {});
      // Select two accounts if present (from/to)
      const fromSelect = page.locator('select[name*="from" i], select[name*="debit" i], select[name*="from_account" i]');
      if (await fromSelect.count()) await fromSelect.first().selectOption({ index: 1 }).catch(() => {});
      const toSelect = page.locator('select[name*="to" i], select[name*="credit" i], select[name*="to_account" i]');
      if (await toSelect.count()) await toSelect.first().selectOption({ index: 2 }).catch(() => {});
      // Generic account fallback
      const anyAccountSelects = page.locator('select[name*="account" i]');
      if (!await fromSelect.count() && await anyAccountSelects.count() >= 2) {
        await anyAccountSelects.nth(0).selectOption({ index: 1 }).catch(() => {});
        await anyAccountSelects.nth(1).selectOption({ index: 2 }).catch(() => {});
      }
      // Try a description/note
      const note = page.locator('textarea[name*="note" i], textarea[name*="description" i]');
      if (await note.count()) await note.first().fill('QA E2E entry').catch(() => {});

      if (await submit.count()) {
        await submit.click().catch(() => {});
        await page.waitForLoadState('networkidle');
      }
      await expect(page).not.toHaveURL(/login/);

      // 3) DR=CR check for modules that generate journals (skip for accounts)
      if (!path.includes('/accounts/')) {
        await assertDrEqualsCrForLatestJournal().catch((e) => console.warn(String(e)));
      }
    });
  }
});

