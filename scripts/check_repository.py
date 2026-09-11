"""Reject runtime/private files and broken local Markdown links in tracked source."""
import re
import subprocess
from pathlib import Path
from urllib.parse import unquote

root = Path(__file__).resolve().parents[1]
files = subprocess.check_output(['git', 'ls-files', '-z'], cwd=root).decode().split('\0')
errors = []
for name in filter(None, files):
    path = Path(name)
    if ((path.name.startswith('.env') and path.name != '.env.example')
        or (path.suffix in {'.sql', '.sqlite', '.sqlite3', '.log'} and name != 'database/schema/mysql-schema.sql')
        or name in {'auth.json', 'api_token'}
        or name.startswith(('vendor/', 'node_modules/', 'public/build/', 'public/js/', 'docs/screenshots/raw/'))
        or (name.startswith('public/uploads/') and path.name != '.gitkeep')):
        errors.append(f'Private or generated file tracked: {name}')
    if path.suffix == '.md' and (root / path).exists():
        for link in re.findall(r'\]\(([^)\s]+)(?:\s+"[^"]*")?\)', (root / path).read_text()):
            if re.match(r'^[a-z]+:', link) or link.startswith('#'):
                continue
            target = unquote(link.split('#', 1)[0])
            if target and not (root / path.parent / target).exists():
                errors.append(f'Broken link in {name}: {target}')
if errors:
    raise SystemExit('\n'.join(errors))
print('Repository file and documentation checks passed.')
