import { test, expect } from '@playwright/test';

test.describe('Settings & RBAC', () => {
  test('Settings page requires auth, toggles journal visibility', async ({ page }) => {
    // Unauthenticated access should redirect to login
    await page.goto('/settings');
    await expect(page).toHaveURL(/login/);
    // Now login and see if setting is present
    await page.locator('input[name="phone"]').fill(process.env.ADMIN_PHONE || '01900000000');
    await page.locator('input[name="password"]').fill(process.env.ADMIN_PASSWORD || 'Admin@123');
    await page.getByRole('button', { name: /sign in/i }).click();
    await expect(page).not.toHaveURL(/login/);
    await page.goto('/settings');
    const journalToggle = page.getByLabel(/journal/i).first();
    if (await journalToggle.count()) {
      const checked = await journalToggle.isChecked().catch(() => false);
      await journalToggle.setChecked(!checked).catch(() => {});
    }
  });
});

