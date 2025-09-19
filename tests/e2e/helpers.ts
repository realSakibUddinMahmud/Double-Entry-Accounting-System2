import { Page, expect } from '@playwright/test';
import mysql from 'mysql2/promise';

export async function login(page: Page, phone: string, password: string) {
  await page.goto('/login');
  await page.getByLabel(/phone/i).fill(phone);
  await page.getByLabel(/password/i).fill(password);
  await page.getByRole('button', { name: /sign in/i }).click();
  await expect(page).not.toHaveURL(/login/);
}

export async function assertDrEqualsCrForLatestJournal() {
  const connection = await mysql.createConnection({
    host: process.env.DB_HOST || '127.0.0.1',
    port: Number(process.env.DB_PORT || 3306),
    user: process.env.DB_USERNAME_TENANT || process.env.DB_USERNAME || 'laravel',
    password: process.env.DB_PASSWORD_TENANT || process.env.DB_PASSWORD || 'secret',
    database: process.env.DB_DATABASE_TENANT || 'tenant_local',
  });
  const [rows] = await connection.query(
    'SELECT SUM(at.debit) AS total_debit, SUM(at.credit) AS total_credit FROM de_journals dj JOIN account_transactions at ON at.id IN (dj.debit_transaction_id, dj.credit_transaction_id) ORDER BY dj.id DESC LIMIT 1'
  );
  const r = (rows as any[])[0] || { total_debit: 0, total_credit: 0 };
  if (Number(r.total_debit) !== Number(r.total_credit)) {
    throw new Error(`DR!=CR for latest journal: DR=${r.total_debit} CR=${r.total_credit}`);
  }
  await connection.end();
}

