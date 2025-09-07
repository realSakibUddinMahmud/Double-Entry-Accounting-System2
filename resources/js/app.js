import './bootstrap';
import * as Sentry from '@sentry/browser';
import { BrowserTracing } from '@sentry/tracing';

if (import.meta.env && import.meta.env.VITE_SENTRY_DSN) {
  Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN,
    integrations: [new BrowserTracing()],
    tracesSampleRate: Number(import.meta.env.VITE_SENTRY_TRACES_SAMPLE_RATE || 0.1),
  });
}
