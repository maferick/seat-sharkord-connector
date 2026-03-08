# Mapping

## Source selection

- Source type can be `group` or `permission`.
- Source key is the SeAT-side authority input.

## Target selection

- Target is a Sharkord role key (e.g. `community.member`).

## Sync mode

- **authoritative**: Sharkord removes provider-managed roles not in current mapped set.
- **additive**: only adds mapped roles.

## Protected local roles

Sharkord keeps protected local roles regardless of authoritative sync.
