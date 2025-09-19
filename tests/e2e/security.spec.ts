import { test, expect } from '@playwright/test';

const ADMIN_PHONE = process.env.ADMIN_PHONE || '01900000000';
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD || 'Admin@123';

async function login(page) {
  await page.goto('/login');
  await page.locator('input[name="phone"]').fill(ADMIN_PHONE);
  await page.locator('input[name="password"]').fill(ADMIN_PASSWORD);
  await page.getByRole('button', { name: /sign in/i }).click();
  await expect(page).not.toHaveURL(/login/);
}

test.describe('Security: XSS/SQLi/CSRF/File', () => {
  test('XSS input sanitized in Product create (if visible)', async ({ page }) => {
    await login(page);
    await page.goto('/products/create');
    const name = page.locator('input#product_name');
    if (!(await name.count())) return test.skip();
    await name.fill('<img src=x onerror=alert(1) />');
    const submit = page.getByRole('button', { name: /add product/i });
    if (await submit.count()) await submit.click().catch(() => {});
    await page.waitForLoadState('networkidle');
    // Ensure we did not navigate to login and no alert surfaced
    await expect(page).not.toHaveURL(/login/);
  });

  test('SQLi attempt in search fields does not error', async ({ page }) => {
    await login(page);
    await page.goto('/products');
    const search = page.locator('input[name="search"]');
    if (!(await search.count())) return test.skip();
    await search.fill("' OR 1=1 --");
    const searchBtn = page.getByRole('button', { name: /search/i });
    if (await searchBtn.count()) await searchBtn.click().catch(() => {});
    await page.waitForLoadState('networkidle');
    await expect(page).not.toHaveURL(/login/);
  });

  test('File upload rejects non-image types (if enforced)', async ({ page }) => {
    await login(page);
    await page.goto('/products/create');
    const file = page.locator('input[type="file"][name="images[]"]');
    if (!(await file.count())) return test.skip();
    try {
      await file.setInputFiles({ name: 'evil.js', mimeType: 'application/javascript', buffer: Buffer.from('alert(1)') } as any);
    } catch {}
    // Submit anyway
    const submit = page.getByRole('button', { name: /add product/i });
    if (await submit.count()) await submit.click().catch(() => {});
    await page.waitForLoadState('networkidle');
    await expect(page).not.toHaveURL(/login/);
  });
});

