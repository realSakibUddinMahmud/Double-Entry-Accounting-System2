## Tenant Scale & Isolation

### Scale Tests
- Create multiple tenants (e.g., 10–50) with distinct domains
- Login flow per-domain; verify dashboard loads
- Parallel data operations (purchases/sales) across tenants

### Isolation Checks
- Ensure cross-tenant queries return zero results (negative tests)
- Validate exports contain only tenant-owned rows

### How-To
- Seed extra tenants via Tinker or seeder
- Configure hosts mapping/domains in test env

