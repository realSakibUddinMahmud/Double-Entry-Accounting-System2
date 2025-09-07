## DB Index / Query Audit

### Process
- Capture slow queries via logs and `EXPLAIN`
- Add composite indexes for common filters/sorts
- Verify improvements with timings in `tests/Performance/*`

### Candidates
- sales(sales_date), sales(store_id, sales_date)
- purchase_items(purchase_id), sale_items(sale_id)
- product_store(product_id, store_id)

### Caching
- Cache aggregate report fragments by (store_id, date bucket)
- Invalidate on write paths (purchase/sale/adjustment)

