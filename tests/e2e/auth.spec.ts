import { test, expect } from '@playwright/test';

const VALID_LOCAL_PHONE = process.env.ADMIN_PHONE || process.env.E2E_ADMIN_PHONE || '01712345678';
const VALID_INTL_PHONE = '+8801712345678';
const INVALID_PREFIX = '01012345678';
const SHORT_PHONE = '0171234567';

const ADMIN_PHONE = process.env.ADMIN_PHONE || process.env.E2E_ADMIN_PHONE;
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD || process.env.E2E_ADMIN_PASSWORD;

test.describe('Authentication', () => {
  test('Login page renders and validates BD phone rules', async ({ page }) => {
    await page.goto('/login');

    // Empty submit
    await page.getByRole('button', { name: /sign in/i }).click();
    await expect(page.getByText(/phone/i)).toBeVisible();
    await expect(page.getByText(/password/i)).toBeVisible();

    // Invalid prefix
    await page.getByLabel(/phone/i).fill(INVALID_PREFIX);
    await page.getByLabel(/password/i).fill('x');
    await page.getByRole('button', { name: /sign in/i }).click();
    await expect(page.locator('.invalid-feedback')).toHaveCountGreaterThan(0);

    // Too short
    await page.getByLabel(/phone/i).fill(SHORT_PHONE);
    await page.getByRole('button', { name: /sign in/i }).click();
    await expect(page.locator('.invalid-feedback')).toHaveCountGreaterThan(0);

    // Accept valid local format (credentials may still fail)
    await page.getByLabel(/phone/i).fill(VALID_LOCAL_PHONE);
    await page.getByLabel(/password/i).fill('incorrect');
    await page.getByRole('button', { name: /sign in/i }).click();
    await expect(page.locator('.alert, .invalid-feedback')).toHaveCountGreaterThan(0);

    // Accept valid international format entry in field
    await page.getByLabel(/phone/i).fill(VALID_INTL_PHONE);
    await page.getByLabel(/password/i).fill('incorrect');
    await page.getByRole('button', { name: /sign in/i }).click();
    await expect(page.locator('.alert, .invalid-feedback')).toHaveCountGreaterThan(0);
  });

  test('login and see dashboard widgets (skips if creds missing)', async ({ page }) => {
    test.skip(!(ADMIN_PHONE && ADMIN_PASSWORD), 'Admin credentials not provided');
    await page.goto('/login');
    await page.locator('input[name="phone"]').fill(ADMIN_PHONE!);
    await page.locator('input[name="password"]').fill(ADMIN_PASSWORD!);
    await Promise.all([
      page.waitForURL('**/home'),
      page.getByRole('button', { name: 'Sign In' }).click(),
    ]);
    await expect(page.getByText(/welcome/i)).toBeVisible();
  });

  test('logout returns to login (skips if creds missing)', async ({ page, context }) => {
    test.skip(!(ADMIN_PHONE && ADMIN_PASSWORD), 'Admin credentials not provided');
    await page.goto('/login');
    await page.locator('input[name="phone"]').fill(ADMIN_PHONE!);
    await page.locator('input[name="password"]').fill(ADMIN_PASSWORD!);
    await Promise.all([
      page.waitForURL('**/home'),
      page.getByRole('button', { name: 'Sign In' }).click(),
    ]);
    await context.clearCookies();
    await page.goto('/home');
    await expect(page).toHaveURL(/.*\/login$/);
  });

  test('invalid login shows error (skips if phone missing)', async ({ page }) => {
    test.skip(!ADMIN_PHONE, 'Phone not provided');
    await page.goto('/login');
    await page.locator('input[name="phone"]').fill(ADMIN_PHONE!);
    await page.locator('input[name="password"]').fill('wrong-pass');
    await Promise.all([
      page.waitForNavigation(),
      page.getByRole('button', { name: 'Sign In' }).click(),
    ]);
    const errorText = /invalid|do not match|failed|error/i;
    await expect(page.locator('body')).toContainText(errorText);
    await expect(page).toHaveURL(/.*\/login|\/$/);
  });
});

