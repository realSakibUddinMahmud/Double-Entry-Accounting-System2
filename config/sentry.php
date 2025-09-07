<?php

return [
    'dsn' => env('SENTRY_LARAVEL_DSN') ?: env('SENTRY_DSN'),

    // Capture release so that Sentry shows which version each error came from
    'release' => trim((string) exec('git rev-parse --short HEAD')) ?: null,

    'traces_sample_rate' => (float) env('SENTRY_TRACES_SAMPLE_RATE', 0.1),
    'profiles_sample_rate' => (float) env('SENTRY_PROFILES_SAMPLE_RATE', 0.0),
];

