# Contributing

Use the local setup in [README.md](README.md) and synthetic demo data. Keep changes focused, document behavior changes, and use short commit subjects without automated co-author or session trailers.

Before opening a pull request:

```bash
composer validate --strict
composer audit
php artisan test
npm ci
npm audit
npm run build
python3 scripts/check_repository.py
```

Keep generated builds, local configuration, database dumps, logs, and uploaded files out of Git. Add regression tests for authentication, authorization, file handling, or database behavior changes. New screenshots must follow [the capture procedure](docs/screenshots/README.md).
