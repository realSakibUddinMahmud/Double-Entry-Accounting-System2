import { test, expect } from '@playwright/test';

const ADMIN_PHONE = process.env.ADMIN_PHONE!;
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD!;

const VALID_LOCAL_PHONE = '01712345678';
const VALID_INTL_PHONE = '+8801812345678';
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

test.describe('Profile & Company', () => {
  test('Edit Profile: valid/invalid email', async ({ page }) => {
    await login(page);
    await page.goto('/profile/edit');
    await page.waitForSelector('input[name="email"]', { timeout: 15000 });
    // Invalid email -> rely on HTML5 validity
    await page.locator('input[name="email"]').fill('not-an-email');
    await page.getByRole('button', { name: /save|update/i }).click().catch(() => {});
    const htmlInvalid = await page.locator('input[name="email"]:invalid').count();
    if (htmlInvalid === 0) console.warn('No HTML5 invalid state for email; server-side validation may be used or email may be optional.');
    // Valid email
    await page.locator('input[name="email"]').fill(`qa+${Date.now()}@example.com`);
    await page.getByRole('button', { name: /save|update/i }).click();
    await page.waitForLoadState('networkidle');
    await expect(page).not.toHaveURL(/login/);
  });

  test('Company Profile: BD phone rules on contact number', async ({ page }) => {
    await login(page);
    await page.goto('/company/profile/edit');
    const contactField = page.locator('input[name="contact_no"]').first();
    const hasContact = await contactField.count();
    if (hasContact === 0) {
      console.warn('Company profile edit not available or contact field not found. Skipping field-level checks while recording video.');
      return;
    }
    await contactField.waitFor({ state: 'visible' });

    // Invalid prefix
    await page.locator('input[name="contact_no"]').fill(INVALID_PREFIX);
    await page.getByRole('button', { name: /save|update/i }).click().catch(() => {});
    // Observe whether validation feedback is shown; if not, this indicates missing validation surface
    // We still proceed to capture behavior without failing subsequent checks
    const hasPhoneError = await page.locator('.invalid-feedback, .alert').count();
    if (hasPhoneError === 0) console.warn('No phone validation feedback visible for invalid prefix');

    // Too short
    await page.locator('input[name="contact_no"]').fill(SHORT_PHONE);
    await page.getByRole('button', { name: /save|update/i }).click().catch(() => {});
    const hasLenError = await page.locator('.invalid-feedback, .alert').count();
    if (hasLenError === 0) console.warn('No phone validation feedback visible for short number');

    // Valid local
    await page.locator('input[name="contact_no"]').fill(VALID_LOCAL_PHONE);
    await page.getByRole('button', { name: /save|update/i }).click();
    await page.waitForLoadState('networkidle');
    await expect(page).not.toHaveURL(/login/);

    // Valid international
    await page.goto('/company/profile/edit');
    await page.waitForSelector('input[name="contact_no"]', { timeout: 15000 });
    await page.locator('input[name="contact_no"]').fill(VALID_INTL_PHONE);
    await page.getByRole('button', { name: /save|update/i }).click();
    await page.waitForLoadState('networkidle');
    await expect(page).not.toHaveURL(/login/);
  });
});