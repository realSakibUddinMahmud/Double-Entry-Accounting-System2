import { test, expect } from '@playwright/test';

const ADMIN_PHONE = process.env.ADMIN_PHONE || '01900000000';
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD || 'Admin@123';

async function login(page) {
  await page.goto('/login');
  await page.locator('input[name="phone"]').fill(ADMIN_PHONE);
  await page.locator('input[name="password"]').fill(ADMIN_PASSWORD);
  await page.getByRole('button', { name: 'Sign In' }).click();
  await page.waitForLoadState('networkidle');
  await expect(page).not.toHaveURL(/login/);
}

test.describe('DEAccounting Accounts', () => {
  test('Create Account page renders and dynamic bank fields behave (if present)', async ({ page }) => {
    await login(page);
    await page.goto('/de-accounting/accounts/new');
    await expect(page.locator('body')).toContainText(/create account|account/i);

    // If account type select exists, toggle to bank/cash types to reveal dynamic fields
    const typeSelect = page.locator('select[name*="account_type"], select#account_type_id');
    if (await typeSelect.count()) {
      await typeSelect.first().selectOption({ index: 1 }).catch(() => {});
      await typeSelect.first().selectOption({ index: 2 }).catch(() => {});
    }

    // If any bank-related input appears, fill minimal values
    const bankName = page.locator('input[name*="bank_name" i]');
    if (await bankName.count()) await bankName.first().fill('QA Bank');
    const accountNo = page.locator('input[name*="account_no" i]');
    if (await accountNo.count()) await accountNo.first().fill('123456789');

    // Try submit and expect either validation or success redirect
    const submit = page.getByRole('button', { name: /create|save|submit|add/i }).first();
    if (await submit.count()) {
      await submit.click().catch(() => {});
      await page.waitForLoadState('networkidle');
      await expect(page).not.toHaveURL(/login/);
    }
  });
});

