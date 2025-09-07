## Data Protection & Compliance

### PII Inventory
- Users: name, phone, email (if present)
- Customers/Suppliers: contact info
- Exports: ensure PDFs/CSVs do not leak hidden fields

### Logging & Redaction
- Use JSON logs; avoid logging PII
- Mask secrets and tokens; avoid request bodies with credentials

### Retention & Rights
- Define retention periods for logs/exports
- Right-to-erasure: delete user-related PII on request across tenant DBs

### Access Control
- RBAC enforced via Spatie permissions
- Tenant isolation validated by tests

