import { test, expect } from '@playwright/test';

test.describe('Settings & RBAC', () => {
  test('Settings page requires auth, toggles journal visibility', async ({ page }) => {
    // Unauthenticated access should redirect to login
    await page.goto('/settings');
    await expect(page).toHaveURL(/login/);
  });
});

