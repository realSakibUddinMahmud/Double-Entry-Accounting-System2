## Performance Notes

### Targets
- p95 auth < 400ms
- p95 stock report < 2s
- p95 sales export < 2s

### Methodology
- Seed scale data with `scripts/seed_scale.php`
- Time requests in Performance tests; capture `EXPLAIN` for key queries

### Findings
- Add indexes based on `EXPLAIN` where needed
- Cache repeated aggregates if thresholds breached

