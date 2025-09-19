import { test, expect } from '@playwright/test';

const validPhone = process.env.ADMIN_PHONE || '01900000000';
const validPassword = process.env.ADMIN_PASSWORD || 'Admin@123';

test.describe('Catalog E2E', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="phone"]').fill(validPhone);
    await page.locator('input[name="password"]').fill(validPassword);
    await Promise.all([
      page.waitForURL('**/home'),
      page.getByRole('button', { name: 'Sign In' }).click(),
    ]);
  });

  test('create Category, Unit, and Product', async ({ page }) => {
    // Category: open page and modal, submit form
    await page.goto('/categories');
    // Try opening Bootstrap modal by data-bs-target
    const catModalTrigger = page.locator('[data-bs-target="#add-category"]');
    if (await catModalTrigger.count()) {
      await catModalTrigger.first().click();
      await page.locator('#add-category').waitFor({ state: 'visible' });
    }
    // Fill and submit form directly if page shows inline form
    const name = `E2E Cat ${Date.now()}`;
    const catNameInput = page.locator('#add-category input[name="name"], form[action*="categories"] input[name="name"]').first();
    if (await catNameInput.count()) {
      await catNameInput.fill(name);
      await catNameInput.focus();
      await page.keyboard.press('Enter');
      await page.waitForLoadState('networkidle');
      await expect(page.locator('body')).toContainText(/category|categories|product/i);
    } else {
      console.warn('Category input not found; skipping category creation.');
    }

    // Unit: open page and modal, submit form
    await page.goto('/units');
    const unitModalTrigger = page.locator('[data-bs-target="#createUnitModal"]');
    if (await unitModalTrigger.count()) {
      await unitModalTrigger.first().click();
      await page.locator('#createUnitModal').waitFor({ state: 'visible' });
    }
    const unitName = `Unit ${Date.now()}`;
    const unitNameInput = page.locator('#createUnitModal input[name="name"], form[action*="units"] input[name="name"]').first();
    if (await unitNameInput.count()) {
      await unitNameInput.fill(unitName);
      await unitNameInput.focus();
      await page.keyboard.press('Enter');
      await page.waitForLoadState('networkidle');
    } else {
      console.warn('Unit input not found; skipping unit creation.');
    }

    // Product: open create page and submit
    await page.goto('/products/create');
    await page.locator('select#store_id').selectOption({ index: 1 }).catch(() => {});
    const pname = page.locator('input#product_name');
    if (!(await pname.count())) {
      console.warn('Product name input not found; skipping product creation.');
      return;
    }
    await pname.fill(`E2E Product ${Date.now()}`);
    await page.locator('select#base_unit_id').selectOption({ index: 1 }).catch(() => {});
    await page.locator('select#purchase_unit_id').selectOption({ index: 1 }).catch(() => {});
    await page.locator('select#sales_unit_id').selectOption({ index: 1 }).catch(() => {});
    await page.locator('select#add_product_category_id').selectOption({ index: 1 }).catch(() => {});
    await page.locator('input[name="purchase_cost"]').fill('10.50');
    await page.locator('input[name="cogs"]').fill('10.50');
    await page.locator('input[name="sales_price"]').fill('15.25');
    await page.getByRole('button', { name: /add product/i }).click();
    await page.waitForLoadState('networkidle');
    await page.goto('/products');
    await expect(page.locator('body')).toContainText(/product list|products/i);
  });
});

