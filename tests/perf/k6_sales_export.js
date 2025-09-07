import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  vus: 3,
  duration: '15s',
  thresholds: {
    http_req_failed: ['rate<0.01'],
    http_req_duration: ['p(95)<1500'],
  },
};

const BASE_URL = __ENV.BASE_URL || 'http://127.0.0.1:8081';

export default function () {
  const res = http.get(`${BASE_URL}/report/sales?start_date=2025-01-01&end_date=2025-12-31`);
  check(res, { 'sales report 200': (r) => r.status === 200 });
  sleep(1);
}

