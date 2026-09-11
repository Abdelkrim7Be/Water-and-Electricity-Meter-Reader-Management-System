# Screenshot capture

The published PNGs show the actual application against a separate database created by `php artisan demo:setup`. All underlying rows are synthetic. No operational database, real portrait, or existing user's session is used for capture.

Before each screenshot, [redact_screenshot.js](../../scripts/redact_screenshot.js) replaces identifying table text and the sidebar identity, then applies blur. Portraits are replaced with the generic demo avatar and blurred. Because the original text and pictures are absent before rasterization, the PNG does not contain those originals. A visible demo label distinguishes these captures from operational data.

## Reproduce

1. Create a new, empty MySQL database and point a separate local environment at it.
2. Run `php artisan demo:setup` and use its generated credentials to sign in.
3. Open `/releves`, `/releveurs`, or `/assignRole` at a 1680 × 940 viewport. Wait for the table or permission matrix to load.
4. Run the redaction script in the browser before each capture. The script refuses sessions whose bootstrap identity is not `Demo Admin`; this is an additional guard, not proof that a database is synthetic.
5. Capture a PNG. Inspect the entire image for names, email addresses, birth dates, portraits, credentials, notifications, and browser overlays before committing it.

With `agent-browser`, after signing into the isolated demo:

```bash
agent-browser --session meter-docs set viewport 1680 940
agent-browser --session meter-docs open http://127.0.0.1:8011/releves
agent-browser --session meter-docs wait --load networkidle
agent-browser --session meter-docs eval --stdin < scripts/redact_screenshot.js
agent-browser --session meter-docs screenshot docs/screenshots/planning.png
```

Reload the page before changing views or taking another capture: redaction intentionally changes the rendered DOM. Keep intermediate captures outside the repository or in ignored `docs/screenshots/raw/`. Never add captured cookies, raw HTML, session state, or credentials to Git.
