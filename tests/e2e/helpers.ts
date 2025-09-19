import { Page, expect } from '@playwright/test';

export async function login(page: Page, phone: string, password: string) {
  await page.goto('/login');
  await page.getByLabel(/phone/i).fill(phone);
  await page.getByLabel(/password/i).fill(password);
  await page.getByRole('button', { name: /sign in/i }).click();
  await expect(page).not.toHaveURL(/login/);
}

