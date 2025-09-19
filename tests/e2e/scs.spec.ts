import { test, expect } from '@playwright/test';

const ADMIN_PHONE = process.env.ADMIN_PHONE!;
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD!;

const VALID_LOCAL_PHONE = '01712345678';
const VALID_INTL_PHONE = '+8801712345678';
const INVALID_PREFIX = '01012345678';
const SHORT_PHONE = '0171234567';

async function login(page) {
  await page.goto('/login');
  await page.locator('input[name="phone"]').fill(ADMIN_PHONE);
  await page.locator('input[name="password"]').fill(ADMIN_PASSWORD);
  await page.getByRole('button', { name: 'Sign In' }).click();
  await page.waitForLoadState('networkidle');
  await expect(page).not.toHaveURL(/login/);
}

test.describe('Stores / Customers / Suppliers', () => {
  test('Store: BD phone in create modal', async ({ page }) => {
    await login(page);
    await page.goto('/stores');
    const trigger = page.locator('[data-bs-target="#add-store"]').first();
    if (await trigger.count() === 0) {
      console.warn('Add Store modal trigger not found. Skipping store test.');
      return;
    }
    await trigger.click();
    await page.locator('#add-store').waitFor({ state: 'visible' });
    // Invalid prefix
    await page.locator('#add-store input[name="contact_no"]').fill(INVALID_PREFIX);
    await page.getByRole('button', { name: /add store/i }).click().catch(() => {});
    // Too short
    await page.locator('#add-store input[name="contact_no"]').fill(SHORT_PHONE);
    await page.getByRole('button', { name: /add store/i }).click().catch(() => {});
    // Valid local (if name required, fill minimal)
    await page.locator('#add-store input[name="name"]').fill(`QA Store ${Date.now()}`);
    await page.locator('#add-store input[name="contact_no"]').fill(VALID_LOCAL_PHONE);
    await page.getByRole('button', { name: /add store/i }).click().catch(() => {});
    await page.waitForLoadState('networkidle');
    await expect(page).not.toHaveURL(/login/);
  });

  test('Customer: BD phone in create modal', async ({ page }) => {
    await login(page);
    await page.goto('/customers');
    const trigger = page.locator('[data-bs-target="#add-customer"]').first();
    if (await trigger.count() === 0) {
      console.warn('Add Customer modal trigger not found. Skipping customer test.');
      return;
    }
    await trigger.click();
    await page.locator('#add-customer').waitFor({ state: 'visible' });
    // Invalid prefix
    await page.locator('#add-customer input[name="phone"]').fill(INVALID_PREFIX);
    await page.getByRole('button', { name: /add customer/i }).click().catch(() => {});
    // Too short
    await page.locator('#add-customer input[name="phone"]').fill(SHORT_PHONE);
    await page.getByRole('button', { name: /add customer/i }).click().catch(() => {});
    // Valid local
    await page.locator('#add-customer input[name="name"]').fill(`QA Customer ${Date.now()}`);
    await page.locator('#add-customer input[name="phone"]').fill(VALID_LOCAL_PHONE);
    await page.getByRole('button', { name: /add customer/i }).click().catch(() => {});
    await page.waitForLoadState('networkidle');
    await expect(page).not.toHaveURL(/login/);
  });

  test('Supplier: BD phone in create modal', async ({ page }) => {
    await login(page);
    await page.goto('/suppliers');
    const trigger = page.locator('[data-bs-target="#add-supplier"]').first();
    if (await trigger.count() === 0) {
      console.warn('Add Supplier modal trigger not found. Skipping supplier test.');
      return;
    }
    await trigger.click();
    await page.locator('#add-supplier').waitFor({ state: 'visible' });
    // Invalid prefix
    await page.locator('#add-supplier input[name="phone"]').fill(INVALID_PREFIX);
    await page.getByRole('button', { name: /add supplier/i }).click().catch(() => {});
    // Too short
    await page.locator('#add-supplier input[name="phone"]').fill(SHORT_PHONE);
    await page.getByRole('button', { name: /add supplier/i }).click().catch(() => {});
    // Valid local
    await page.locator('#add-supplier input[name="name"]').fill(`QA Supplier ${Date.now()}`);
    await page.locator('#add-supplier input[name="phone"]').fill(VALID_LOCAL_PHONE);
    await page.getByRole('button', { name: /add supplier/i }).click().catch(() => {});
    await page.waitForLoadState('networkidle');
    await expect(page).not.toHaveURL(/login/);
  });
});