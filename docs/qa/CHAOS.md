## Chaos Testing

### DB Outage Scenario
- Steps: baseline health → kill DB → verify /health degrades → restore DB
- Workflow: `.github/workflows/chaos.yml`
- Expected: app reports degraded; recovers after DB restored

### Future Scenarios
- Cache outage
- Slow queries / network latency injection
- Disk full / permission errors

