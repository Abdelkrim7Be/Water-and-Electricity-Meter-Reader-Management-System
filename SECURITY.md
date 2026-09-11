# Security

Report a suspected vulnerability through this repository's **Security → Report a vulnerability** tab if enabled. Otherwise, open an issue requesting a private reporting channel without including credentials, personal data, or exploit details.

Do not attach database exports, `.env` files, password hashes, authentication cookies, uploaded portraits, or unredacted screenshots to public issues or pull requests.

The application is an internship project maintained as a portfolio repository. Passing automated checks does not constitute a security certification. Review deployment settings and access policies before using real operational data.

## Data handling

- Local secrets belong in ignored `.env` files. Production requires its own credentials and application key.
- The tracked SQL baseline contains schema and migration metadata only. `demo:setup` creates synthetic records and a fresh random admin password in an empty local/testing MySQL database.
- Portraits live under `storage/app/private/releveurs` and are served through authenticated, permission-checked routes. Run `php artisan uploads:privatize` when upgrading a legacy installation.
- Role permissions are enforced by the server. Login is rate limited, state-changing routes use CSRF protection, and session IDs are renewed on login.
- Password hashes and account recovery codes are excluded from user JSON. Pages receive only the user fields needed by the interface.
- CI checks dependencies, repository contents, tests, builds, and reachable Git history with Gitleaks.

Previously published information cannot be recalled from other people's clones, forks, or caches. If actual credentials were exposed, revoke or rotate them; deleting a file or rewriting Git history is not a substitute.
