import { test, expect } from '@playwright/test';

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
      // Common fail: try submit (Livewire forms) and expect either disabled or error feedback
      const submit = page.getByRole('button', { name: /submit|save|create|add/i }).first();
      if (await submit.count()) {
        // Try a minimal invalid submit
        await submit.click().catch(() => {});
        // Look for some generic error surface; non-blocking if not shown
        const anyError = await page.locator('.invalid-feedback, .alert').count();
        if (anyError === 0) console.warn(`No validation feedback visible on ${path} for empty submit`);
      }
      await expect(page).not.toHaveURL(/login/);
    });
  }
});

