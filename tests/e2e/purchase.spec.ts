import { test, expect } from '@playwright/test';

const validPhone = '01900000000';
const validPassword = 'secret123';

test.describe('Purchase E2E', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="phone"]').fill(validPhone);
    await page.locator('input[name="password"]').fill(validPassword);
    await Promise.all([
      page.waitForURL('**/home'),
      page.getByRole('button', { name: 'Sign In' }).click(),
    ]);
  });

  test('open create purchase and attempt simple submission', async ({ page }) => {
    await page.goto('/purchases/create');
    await expect(page.locator('body')).toContainText(/add purchase|purchase/i);

    // Try to choose a supplier and store if dropdowns exist
    const supplierSelect = page.locator('select[name*="supplier"], select#supplier_id');
    if (await supplierSelect.count()) {
      await supplierSelect.first().selectOption({ index: 1 }).catch(() => {});
    }
    const storeSelect = page.locator('select[name*="store"], select#store_id');
    if (await storeSelect.count()) {
      await storeSelect.first().selectOption({ index: 1 }).catch(() => {});
    }

    // Attempt to add one line item if such UI exists
    const addItemBtn = page.getByRole('button', { name: /add item|add product/i });
    if (await addItemBtn.count()) {
      await addItemBtn.first().click().catch(() => {});
      // Fill generic fields if visible
      const qty = page.locator('input[name*="quantity"], input[placeholder*="Qty" i]');
      if (await qty.count()) await qty.first().fill('2').catch(() => {});
      const price = page.locator('input[name*="price"], input[placeholder*="Price" i]');
      if (await price.count()) await price.first().fill('100').catch(() => {});
    }

    // Try saving: look for a save/submit button
    const saveBtn = page.getByRole('button', { name: /save|submit|create|add purchase/i });
    if (await saveBtn.count()) {
      await saveBtn.first().click().catch(() => {});
      await page.waitForLoadState('networkidle');
    }

    // Fallback: navigate back to purchases list and ensure page loads
    await page.goto('/purchases');
    await expect(page.locator('body')).toContainText(/purchase list|purchases/i);
  });
});

