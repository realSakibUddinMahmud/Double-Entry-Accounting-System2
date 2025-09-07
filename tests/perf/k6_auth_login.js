import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  vus: 5,
  duration: '15s',
  thresholds: {
    http_req_failed: ['rate<0.01'],
    http_req_duration: ['p(95)<1000'],
  },
};

const BASE_URL = __ENV.BASE_URL || 'http://127.0.0.1:8081';

export default function () {
  const res = http.get(`${BASE_URL}/login`);
  check(res, { 'login page 200': (r) => r.status === 200 });
  sleep(1);
}

