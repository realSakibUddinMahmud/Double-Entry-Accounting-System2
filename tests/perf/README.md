# k6 Perf Checks (optional)

Run locally (server on 8081):

- `npm i -g k6` (if not installed)
- `BASE_URL=http://127.0.0.1:8081 k6 run tests/perf/k6_auth_login.js`
- `BASE_URL=http://127.0.0.1:8081 k6 run tests/perf/k6_sales_export.js`

Thresholds:
- auth login: p(95) < 1000ms
- sales report: p(95) < 1500ms