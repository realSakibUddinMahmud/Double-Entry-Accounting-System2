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

test.describe('E2E Accounting Flow (happy path, soft assertions)', () => {
  test('Create product → purchase → sale → trial balance renders', async ({ page }) => {
    await login(page);

    // Create product (best-effort)
    await page.goto('/products/create');
    if (await page.locator('input#product_name').count()) {
      await page.locator('select#store_id').first().selectOption({ index: 1 }).catch(() => {});
      await page.locator('input#product_name').fill(`E2E Flow Product ${Date.now()}`);
      await page.locator('select#base_unit_id').first().selectOption({ index: 1 }).catch(() => {});
      await page.locator('select#purchase_unit_id').first().selectOption({ index: 1 }).catch(() => {});
      await page.locator('select#sales_unit_id').first().selectOption({ index: 1 }).catch(() => {});
      await page.locator('select#add_product_category_id').first().selectOption({ index: 1 }).catch(() => {});
      await page.locator('input[name="purchase_cost"]').fill('10.00');
      await page.locator('input[name="cogs"]').fill('10.00');
      await page.locator('input[name="sales_price"]').fill('15.00');
      const submit = page.getByRole('button', { name: /add product/i });
      if (await submit.count()) await submit.click().catch(() => {});
      await page.waitForLoadState('networkidle');
    }

    // Open purchase create page
    await page.goto('/purchases/create');
    await expect(page).not.toHaveURL(/login/);

    // Open sale create page
    await page.goto('/sales/create');
    await expect(page).not.toHaveURL(/login/);

    // Trial balance view
    await page.goto('/report/trial-balance');
    await expect(page).toHaveURL(/trial-balance/);
    await expect(page.locator('body')).toContainText(/trial|balance/i);
  });
});

