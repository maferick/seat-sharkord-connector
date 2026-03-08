# Setup

1. Install package in SeAT and run migrations.
2. Open Sharkord Connector settings.
3. Configure:
   - Sharkord base URL
   - API base path (`/api/v1/ext`)
   - signing mode (`hmac`)
   - signing secret
   - request timeout
   - diagnostics bearer token
4. Configure eligibility defaults and role-sync mode.
5. Add role mappings (SeAT group/permission -> Sharkord role key).
6. Run connectivity diagnostics (`providers`, `health`).
7. Preview normalized payload for a real user fixture.
8. Execute manual upsert sync.
