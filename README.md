# seat-sharkord-connector

SeAT plugin/package that treats SeAT as source of truth and pushes normalized signed payloads to Sharkord `/api/v1/ext` endpoints.

## Architecture split

- **SeAT package owns:** identity sourcing, eligibility, role mapping, signed outbound sync, settings, preview/testing.
- **Sharkord owns:** lifecycle/state enforcement, managed fields, runtime role application, auth/session issuance, audit state.

## Sharkord endpoints used

- `POST /api/v1/ext/auth/login`
- `POST /api/v1/ext/auth/link`
- `POST /api/v1/ext/users/upsert`
- `POST /api/v1/ext/users/disable`
- `POST /api/v1/ext/users/restore`
- `POST /api/v1/ext/users/soft-delete`
- `POST /api/v1/ext/roles/sync`
- `POST /api/v1/ext/roles/preview`
- `POST /api/v1/ext/eligibility/preview`
- `GET /api/v1/ext/providers`
- `GET /api/v1/ext/providers/seat/health`

## Signing

HMAC SHA-256 over `provider.timestamp.nonce.rawBody` with headers expected by Sharkord:

- `x-sharkord-provider`
- `x-sharkord-timestamp`
- `x-sharkord-nonce`
- `x-sharkord-signature`
- `x-sharkord-request-id`

## Installation

1. Add package to SeAT composer dependencies.
2. Install and enable plugin.
3. Run plugin migrations.
4. Configure Sharkord URL/secret/mappings in SeAT admin.
5. Run diagnostics health test and first preview/upsert.

See `docs/setup.md` for a first-run checklist.
