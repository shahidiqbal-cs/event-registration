# Setup & run

Event Registration System — **CodeIgniter 3** (not Laravel).

For what the app does, see [`README.md`](README.md).

---

## Requirements

| Tool     | Version                                              |
|----------|------------------------------------------------------|
| PHP      | 7.2 – 8.1 (developed / tested on 7.4)                 |
| Composer | 2.x                                                  |
| MySQL    | 5.7+ / MariaDB 10.3+                                  |
| PHP ext. | `mysqli`, `mbstring`, `intl`, `gd`, `zip`             |

---

## Steps

### 1. Install the framework + dependencies

```bash
composer install
```

CodeIgniter is pulled into `vendor/codeigniter/framework/` — it is **not**
committed. `index.php` loads it from there automatically.

### 2. Create the environment file

```bash
cp .env.example .env
```

Edit `.env`:

```
CI_ENV=development          # development | testing | production
DB_HOST=localhost
DB_USER=root
DB_PASS=your_password
DB_NAME=example
DB_DRIVER=mysqli
```

`.env` is git-ignored and read by `index.php` before the framework boots. Real
OS / web-server environment variables override the file, so production can skip
the file entirely.

### 3. Create the database

```bash
mysql -u root -p -e "CREATE DATABASE example CHARACTER SET utf8 COLLATE utf8_general_ci;"
```

Use the same name you put in `DB_NAME`.

### 4. Build the schema + seed the login accounts

```bash
php index.php migrate
```

Runs the migrations in `application/migrations/`:

| # | Migration | Contents |
|---|-----------|----------|
| 001 | `create_initial_schema` | all tables |
| 002 | `seed_data` | login accounts (`admin`, `desk`) + one sample region |

Reference data (zones, cities, halqas, ideology, propagation, titles, majlis
amomi) is entered through the app — see the first-run checklist below.

Rollback / target a version:

```bash
php index.php migrate version 0     # drop everything
php index.php migrate version 1     # go to a specific version
```

Migrations run **only** from the command line; `migration_enabled` is already
`TRUE` in `application/config/migration.php`.

### 5. Run

```bash
php -S localhost:8000
```

Open <http://localhost:8000>. `base_url` auto-detects the host, so localhost,
a `.test` vhost or a sub-folder deployment all work with no config change.

* **Apache** — point the document root at the project root; the bundled
  `.htaccess` handles the front-controller rewrite (needs `mod_rewrite` and
  `AllowOverride All`).
* **Nginx** — `try_files $uri $uri/ /index.php?$query_string;`.

### 6. Log in

| User    | Password   | Role  |
|---------|------------|-------|
| `admin` | `admin123` | admin |
| `desk`  | `desk123`  | desk  |

Change the passwords after first login:

```sql
UPDATE `user` SET `user_password` = MD5('new-password') WHERE `user_name` = 'admin';
```

---

## First-run checklist

1. Log in as `admin`.
2. **Organisation** — add Region → Zones → Cities → Halqas.
3. **Ideology / Propagation / Majlis Amomi / Titles** — add the values you use.
4. **Participants** — add people (or import a database via **Maintenance**).
5. **Events** — create an event and its participant-selection criteria; the
   invite list is built automatically.
6. **Events → activate** the event, then use **Attendance** to mark people in.

