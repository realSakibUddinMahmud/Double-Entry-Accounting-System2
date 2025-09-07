import { test, expect } from '@playwright/test';

// Using valid login (admin) then simulate restricted behavior by visiting admin pages without session
const validPhone = '01900000000';
const validPassword = 'secret123';

test('restricted access without session redirects to login', async ({ page, context }) => {
  await page.goto('/login');
  await page.locator('input[name="phone"]').fill(validPhone);
  await page.locator('input[name="password"]').fill(validPassword);
  await Promise.all([
    page.waitForURL('**/home'),
    page.getByRole('button', { name: 'Sign In' }).click(),
  ]);

  // Clear cookies to drop session and try an admin page
  await context.clearCookies();
  await page.goto('/products');
  await expect(page).toHaveURL(/.*\/login$/);
});

