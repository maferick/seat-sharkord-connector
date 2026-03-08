# Troubleshooting

## Signature rejected

- Check secret mismatch.
- Check canonical string order.
- Check timestamp freshness.
- Check nonce/request-id uniqueness.

## Login blocked after sync

- Verify lifecycle/account state in Sharkord diagnostics.
- Check eligibility output and reason codes from SeAT preview.

## Role mismatch

- Validate SeAT mapping table.
- Validate authoritative vs additive mode.
- Validate protected local role expectations.

## No eligible main character

- Verify main-character strategy config.
- Verify fallback behavior configuration.
- Verify alliance/corp/guest/deny rule sets.
