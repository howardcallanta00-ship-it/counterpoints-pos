# Counterpoint POS Account Management

Counterpoint is a secure, responsive administration website for managing POS customer and staff accounts. It combines a public marketing site, authenticated management screens, MySQL persistence, safe avatar processing, automated tests, and Docker-based Render readiness in one CodeIgniter 4 project.

## Features

- Public landing, about, login, and JSON health-check pages
- Session authentication with generic login failures, session ID regeneration, and POST-only logout
- Protected customer and user directories with create and edit workflows
- Unique usernames, approved staff roles, secure password hashing, and password-preserving edits
- Validated JPG/PNG avatar uploads, 2 MB limit, 300 x 300 processing, safe generated names, and bundled placeholder
- CSRF protection, escaped output, model-based database access, secure production errors, and no destructive record deletion
- MySQL migrations and intentional demo seeders
- Responsive Bootstrap 5 interface and accessible validation feedback
- PHPUnit/CodeIgniter feature tests
- Docker, Render Blueprint, configurable persistent avatar storage, and Clever Cloud compatibility

## Stack and structure

PHP 8.2+, CodeIgniter 4, Composer, MySQL 8 compatible, Bootstrap 5, vanilla JavaScript, PHPUnit, Apache, and Docker.

Key directories: `app/Controllers` handles requests; `app/Models` owns persistence; `app/Views` contains layouts and screens; `app/Filters` protects routes; `app/Database` contains migrations and seeders; `tests` contains isolated feature tests; `public` is the only web root.

## Local installation

Prerequisites: PHP 8.2 or later with `fileinfo`, `gd`, `intl`, and `mysqli`; Composer 2; and MySQL 8 or a compatible service.

1. Clone the repository and enter its directory.
2. Run `composer install`.
3. Create databases: `CREATE DATABASE pos_accounts CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;` and `CREATE DATABASE pos_accounts_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`.
4. Create a least-privilege local MySQL user and grant it access only to those databases.
5. Copy `.env.example` to `.env`. Never commit `.env`.
6. Set `CI_ENVIRONMENT`, `APP_BASE_URL`, and the `DB_*` values. Set `TEST_DB_NAME=pos_accounts_test` for tests.
7. Run `php spark migrate`.
8. Start with `php spark serve`, then open `http://localhost:8080`.

`APP_KEY` should be a long random value. `DB_DRIVER` should remain `MySQLi`. Leave `DB_SSL_CA` empty locally unless the server requires a CA bundle. `AVATAR_UPLOAD_PATH` can be empty locally, which uses `public/uploads/avatars`.

## Demo data and administrator

Seeding is deliberate and is never run on application startup. Set a temporary administrator password of at least 12 characters in your uncommitted environment, for example `SEED_ADMIN_PASSWORD='temporary-long-random-password'`, then run:

```sh
php spark db:seed DatabaseSeeder
```

The administrator username is `admin`. Remove `SEED_ADMIN_PASSWORD` after seeding and change the password through an approved operational process. Other seeded accounts use documented demo-only passwords in the seeder and must never be treated as production accounts.

## Tests

Configure `TEST_DB_NAME` with a disposable database, then run `composer test` or `vendor/bin/phpunit`. Tests refresh their schema and seed only the test database. The suite covers public pages, health, login success and failure, logout, route protection, authenticated lists, customer validation/create/update/404 behavior, duplicate usernames, user creation/update, hashing, and password preservation. Upload transport cases should use CI-generated image fixtures; application validation also enforces MIME, decoded image content, extension mapping, and size.

For additional checks run `composer validate --strict` and syntax-check application PHP files with `php -l`. Verify migrations against an empty test database with `php spark migrate --all --group tests` where the environment is configured for the test group.

## Docker

Build and run locally:

```sh
docker build -t counterpoint-pos .
docker run --rm -p 8080:8080 --env-file .env -e PORT=8080 counterpoint-pos
```

The multi-stage image installs production dependencies only, enables MySQL and GD support, serves `public/`, honors Render's `PORT`, and prepares writable runtime paths. Run migrations as an explicit one-time release operation, not in the container entrypoint.

## Clever Cloud MySQL

In Clever Cloud, create a MySQL add-on yourself, open its dashboard, and retrieve the add-on variables. Do not commit or paste those credentials into source files. Map them into Render as follows:

| Clever Cloud | Render application |
|---|---|
| `MYSQL_ADDON_HOST` | `DB_HOST` |
| `MYSQL_ADDON_PORT` | `DB_PORT` |
| `MYSQL_ADDON_DB` | `DB_NAME` |
| `MYSQL_ADDON_USER` | `DB_USER` |
| `MYSQL_ADDON_PASSWORD` | `DB_PASSWORD` |

Set `DB_DRIVER=MySQLi`. If Clever Cloud requires TLS, place the CA certificate in the image or mounted secret file and set `DB_SSL_CA` to its absolute path. The application verifies the certificate; do not disable verification globally.

## Render setup

1. Push this repository to GitHub.
2. In Render, create a Blueprint or Docker web service from the repository. The included `render.yaml` disables automatic deployment by default.
3. Add all `DB_*` secrets from Clever Cloud, a production `APP_BASE_URL` ending in `/`, a generated `APP_KEY`, `CI_ENVIRONMENT=production`, and `SESSION_DRIVER=CodeIgniter\\Session\\Handlers\\FileHandler`.
4. Set the health-check path to `/health`.
5. On the free Render plan set `AVATAR_STORAGE_DRIVER=database`; processed avatars are stored in Clever Cloud MySQL and survive Render restarts without a disk.
6. Set `RUN_MIGRATIONS_ON_START=true`. CodeIgniter migrations are idempotent and run before Apache starts, which is required because free Render services do not include shell access.
7. For the first deployment only, set `SEED_ADMIN_PASSWORD` to a temporary value of at least 12 characters. Startup creates `admin` only when it does not already exist. Remove the variable immediately after the first successful deployment and redeploy.
8. Verify `/health`, public pages, login, both directories, record edits, logout, and an avatar replacement over HTTPS.

Free Render filesystems are ephemeral. This project therefore supports `AVATAR_STORAGE_DRIVER=database` for no-cost deployments. Paid installations can continue using filesystem storage with `AVATAR_UPLOAD_PATH`, or adopt S3-compatible object storage at larger scale.

## Security notes

Use least-privilege database credentials, rotate initial credentials after setup, restrict Render shell access, keep production errors disabled, use HTTPS, back up MySQL, and review dependency alerts. The committed `.env.example` contains placeholders only. `.env`, uploads, sessions, logs, caches, vendor files, and credential-like files are ignored. Never expose password hashes in output or logs.

## Troubleshooting

- **Database connection:** confirm host, database name, username, password, firewall access, and that Render can reach Clever Cloud.
- **Wrong port:** use the exact `MYSQL_ADDON_PORT`; do not assume 3306.
- **TLS error:** verify `DB_SSL_CA` exists in the running container and matches the provider CA. Keep verification enabled.
- **Writable paths:** ensure `writable` and `AVATAR_UPLOAD_PATH` exist and are writable by `www-data`.
- **Image upload failure:** confirm GD and fileinfo are enabled, the file is decoded as JPG/PNG, it is no larger than 2 MB, and the disk is not full.
- **Missing extension:** inspect `php -m`; rebuild the supplied image rather than installing extensions at runtime.
- **Migration failure:** check database privileges and schema state, back up data, then inspect `php spark migrate:status` before retrying.
- **Session issue:** confirm cookies are accepted, HTTPS is stable, `APP_BASE_URL` is correct, and the session path is writable.
- **HTTPS redirect loop:** ensure Render's proxy headers reach Apache and `APP_BASE_URL` uses `https://`; do not add a second conflicting redirect layer.
- **Avatars vanish:** attach and correctly mount the persistent disk or use object storage.
- **Health check fails:** inspect Render logs, confirm `PORT` is set by Render, and verify `/health` returns `{"status":"ok"}` without authentication.

## License

MIT. See `LICENSE`.
