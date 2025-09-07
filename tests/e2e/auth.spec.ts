import { test, expect } from '@playwright/test';

const validPhone = '01900000000';
const validPassword = 'secret123';

test('login and see dashboard widgets', async ({ page }) => {
  await page.goto('/login');
  await page.locator('input[name="phone"]').fill(validPhone);
  await page.locator('input[name="password"]').fill(validPassword);
  await Promise.all([
    page.waitForURL('**/home'),
    page.getByRole('button', { name: 'Sign In' }).click(),
  ]);
  await expect(page.getByText('Welcome')).toBeVisible();
});

test('logout returns to login', async ({ page, context }) => {
  await page.goto('/login');
  await page.locator('input[name="phone"]').fill(validPhone);
  await page.locator('input[name="password"]').fill(validPassword);
  await Promise.all([
    page.waitForURL('**/home'),
    page.getByRole('button', { name: 'Sign In' }).click(),
  ]);
  // Simulate logout by clearing session cookies, then assert redirect
  await context.clearCookies();
  await page.goto('/home');
  await expect(page).toHaveURL(/.*\/login$/);
});

test('invalid login shows error', async ({ page }) => {
  await page.goto('/login');
  await page.locator('input[name="phone"]').fill(validPhone);
  await page.locator('input[name="password"]').fill('wrong-pass');
  await Promise.all([
    page.waitForNavigation(),
    page.getByRole('button', { name: 'Sign In' }).click(),
  ]);
  // Generic check for invalid credentials message
  const errorText = /invalid|do not match|failed|error/i;
  await expect(page.locator('body')).toContainText(errorText);
  await expect(page).toHaveURL(/.*\/login|\/$/);
});

