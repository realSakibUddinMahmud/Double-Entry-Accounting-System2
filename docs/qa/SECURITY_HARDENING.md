## Security Hardening

### Web Server
- Nginx security headers: X-Frame-Options, X-Content-Type-Options, Referrer-Policy, Permissions-Policy, CSP
- Basic rate limiting: 10 r/s with burst 20

### App Config
- JSON logging in non-local
- CSRF enabled (default), cookies SameSite=Lax recommended
- CORS: restrict to known origins (configure if SPA/frontend exists)

### CI
- ZAP baseline scheduled; fail on medium/high after allowlisting
- Secrets scan (Gitleaks) on PRs and pushes
- SBOM artifacts for each build

