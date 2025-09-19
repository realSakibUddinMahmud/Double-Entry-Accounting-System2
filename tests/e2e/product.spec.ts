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

test.describe('Products create/edit', () => {
  test('Create product with minimal required fields (if available)', async ({ page, context, browserName }) => {
    await login(page);
    await page.goto('/products/create');
    // Assert access granted by checking presence of the create form or Add Product button
    const form = page.locator('form#createProductForm');
    const addBtn = page.getByRole('button', { name: /add product/i });
    const accessDenied = page.getByText(/access denied/i);
    if (await accessDenied.isVisible().catch(() => false)) {
      test.fail(true, 'Access denied for product-create. RBAC may be missing.');
    }
    await expect(form.or(addBtn)).toBeVisible();

    // Helper to select first available non-empty option
    const selectFirst = async (selector: string) => {
      const sel = page.locator(selector);
      if (await sel.count() === 0) return false;
      const options = await sel.locator('option').all();
      for (const opt of options) {
        const val = await opt.getAttribute('value');
        if (val && val.length > 0) {
          await sel.selectOption(val).catch(() => {});
          return true;
        }
      }
      return false;
    };

    // Try select store
    await selectFirst('select#store_id');
    // Product name
    const nameInput = page.locator('input#product_name');
    if (await nameInput.count()) {
      await nameInput.fill(`QA Product ${Date.now()}`);
    }
    // Units
    await selectFirst('select#base_unit_id');
    await selectFirst('select#purchase_unit_id');
    await selectFirst('select#sales_unit_id');
    // Category
    await selectFirst('select#add_product_category_id');
    // Costs/prices
    const setIfExists = async (selector: string, value: string) => {
      const el = page.locator(selector);
      if (await el.count()) await el.fill(value);
    };
    await setIfExists('input[name="purchase_cost"]', '10.50');
    await setIfExists('input[name="cogs"]', '10.50');
    await setIfExists('input[name="sales_price"]', '15.99');
    // Optional tax
    await selectFirst('select#tax_id');
    await selectFirst('select#tax_method');

    // Additional Fields if present
    const additionalInputs = page.locator('[name^="additional_fields["]');
    const count = await additionalInputs.count();
    for (let i = 0; i < count; i++) {
      const el = additionalInputs.nth(i);
      const tag = await el.evaluate((e) => e.tagName.toLowerCase());
      const type = await el.getAttribute('type');
      if (tag === 'select') {
        const ok = await (async () => {
          const opts = await el.locator('option').all();
          for (const opt of opts) {
            const v = await opt.getAttribute('value');
            if (v && v.length > 0) { await el.selectOption(v).catch(() => {}); return true; }
          }
          return false;
        })();
        if (!ok) continue;
      } else if (type === 'checkbox') {
        await el.check().catch(() => {});
      } else if (tag === 'textarea') {
        await el.fill('QA additional text').catch(() => {});
      } else {
        await el.fill('QA value').catch(() => {});
      }
    }

    // Upload an image if input exists (use in-memory 1x1 PNG)
    const imgInput = page.locator('input[type="file"][name="images[]"]');
    if (await imgInput.count()) {
      const onePxPngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMB/1dRZb0AAAAASUVORK5CYII=';
      try {
        await imgInput.setInputFiles({
          name: 'qa-image.png',
          mimeType: 'image/png',
          buffer: Buffer.from(onePxPngBase64, 'base64'),
        } as any);
      } catch (e) {
        // non-fatal
      }
    }

    // Submit the form
    const submit = page.getByRole('button', { name: /add product/i });
    if (await submit.count()) {
      await submit.click().catch(() => {});
      await page.waitForLoadState('networkidle');
      await expect(page).not.toHaveURL(/login/);
      // After submit, either stay on page with validation or redirect to products list
      const postSuccess = page.url().includes('/products');
      if (!postSuccess) {
        // try a soft navigate to products index for verification
        await page.goto('/products');
      }
    } else {
      console.warn('Add Product submit button not found.');
    }

    // Navigate to products index for sanity
    await page.goto('/products');
    await expect(page).not.toHaveURL(/login/);
  });
});

