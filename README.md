# Event Registration System

A web application for an organisation that runs recurring **training events /
seminars** and needs to track, for each event, **who is invited and who
actually attended**.

It keeps a central roster of people ("participants"), lets an organiser build an
event by choosing *which* participants it is for (by training level, council
membership, outreach role and geographic unit), turns that selection into a live
attendance sheet the front desk marks off on the day, and afterwards produces
summaries, printable lists, name badges and Excel exports.

Built on **CodeIgniter 3** (PHP). English interface, Urdu data and printed
output.

---

## What it does

### Participants — the master roster

`Participants` menu. Each record holds name, father's name, contact number,
e-mail, CNIC, blood group, temporary/permanent address, and the classifications
used to target events:

| Field | Meaning |
|-------|---------|
| **Ideology** | training status (course levels) |
| **Propagation** | outreach / da'wah role |
| **Majlis Amomi** | general-council membership |
| **Intazami** | organisational / management role |
| **Location** | the Halqa → City → Zone → Region the person belongs to |

Create, edit, view, delete, filter the list, **export to Excel**, and a
**trash / restore** flow so removed people can be recovered or purged.

### Events — build the invite list from selected categories

`Events` menu. Creating an event captures name, date, location, print header and
organiser, plus the **participant-selection criteria**:

| Criterion | Options |
|-----------|---------|
| **Ideology** | *all*, or a custom set of training levels |
| **Majlis Amomi** | *all*, or a custom set |
| **Propagation** | *all*, or a custom set |
| **Organisation scope** | *all zones*, specific zones, or specific cities |

On save the app **rebuilds the event's registration list** — every *active*
participant that matches the criteria is added, anyone who no longer matches is
removed. Editing the criteria later re-syncs the list the same way.

### Activate an event and mark attendance

* **Activate** — one event at a time is the *active event* (`Events → activate`).
  All attendance screens operate on it; activating again deactivates it.
* **Attendance** (`Attendance` menu) — the live sheet for the active event. For
  each person the desk marks **Present**, **Absent** or **On leave**; times are
  stamped and the present/total counters update live. Supports manual entry of a
  participant by id, and filtering the sheet by ideology, city or status.

### During / after the event

All under the `Attendance` / `Registration` menu, for the active event:

* **Groups** — split attendees into numbered discussion groups with per-group
  present/total counts.
* **Badges** — printable name badges (everyone / present only / a custom id list)
  with configurable header, sub-heading and footer.
* **Summary** — attendance roll-ups by Zone, City and Halqa.
* **Print sections** — printable present / absent / leave / panel / desk lists.
* **Excel export** of the registration data by status.

### Organisation setup — Region / Zone / City / Halqa

`Organisation` menu. A four-level hierarchy that every participant and every
event is scoped against:

```
Region  →  Zone  →  City  →  Halqa
```

Each level is a CRUD screen (`Regions`, `Zones`, `Cities`; Halqas hang off a
City).

### Classification lists

Admin-managed CRUD screens for the values used on participant and event forms:
**Ideology**, **Propagation**, **Majlis Amomi**, and **Titles** (reusable
event / seminar titles).

### Files

`Files` menu. Upload and download shared documents (blank feedback slips, tag
templates, report forms, …). Files live in `assets/files/`.

### Feedback

`Feedback` menu. A simple log of free-text feedback entries (name, type,
message).

### Database tool (Maintenance)

`Maintenance` menu, admin only.

* **Backup** — downloads the entire database as a `.sql.zip`.
* **Import** — upload a `.sql.zip` to restore / replace the database.

---

## Roles

Login is required for everything. Two roles, seeded by the migration:

| Role | Purpose |
|------|---------|
| `admin` | full access — organisation setup, classification lists, participants, events, database tool |
| `desk`  | the attendance desk on event day |

Enforced admin-only screens: **Titles**, **Majlis Amomi**, **Maintenance**.
Participants, Events and Attendance are open to both roles.

> The guard on **Organisation**, **Ideology** and **Propagation** currently uses
> `&&` where it should be `||`, so a `desk` user can still open those screens.
> Tighten those three controllers if the distinction matters.

Passwords are stored as **unsalted MD5** (the app MD5-hashes the submitted
password before comparing) — acceptable for an internal tool on a trusted
network; move to `password_hash()` if it is ever exposed more widely.

---

## Tech stack

| | |
|---|---|
| Framework | CodeIgniter 3.1.13 — installed via Composer, **not committed** |
| Language | PHP 7.2 – 8.1 (developed on 7.4) |
| Database | MySQL 5.7+ / MariaDB 10.3+ (`mysqli`) |
| Front end | AdminLTE 2 / Bootstrap 3, jQuery, DataTables |
| Excel export | PHPExcel (bundled under `application/libraries/`) |
| Schema | CodeIgniter migrations (`application/migrations/`) |

### Layout

```
application/
  controllers/   Dashboard, Participant, Event, Registration, Organization,
                 Ideology, Propagation, Majlis_amomi, Title, File, Feedback,
                 Maintenance, User, Migrate
  models/        one per domain table
  migrations/    001 schema · 002 seed (login accounts + a sample region)
  config/        migration_enabled = TRUE, sequential, version 2
assets/          AdminLTE theme, app custom.js, logo, uploads (assets/files/)
index.php        front controller + .env loader
composer.json    pulls in codeigniter/framework
```

The framework itself is **not** in the repo — `composer install` puts it in
`vendor/codeigniter/framework/` and `index.php` loads it from there (falling
back to a local `./system` if one exists).

---

## Setup

See **[`run_instruction.md`](run_instruction.md)** for the full step-by-step
guide. Short version:

```bash
composer install
cp .env.example .env          # then set DB_* values
mysql -u root -p -e "CREATE DATABASE event_registration CHARACTER SET utf8 COLLATE utf8_general_ci;"
php index.php migrate
php -S localhost:8000
```

Log in at <http://localhost:8000> with **`admin` / `admin123`** (or
`desk` / `desk123`) and change the password:

```sql
UPDATE `user` SET `user_password` = MD5('new-password') WHERE `user_name` = 'admin';
```

### First-run checklist

1. Log in as `admin`.
2. **Organisation** — add Region → Zones → Cities → Halqas.
3. **Ideology / Propagation / Majlis Amomi / Titles** — add the values you use.
4. **Participants** — add people (or import a database via **Maintenance**).
5. **Events** — create an event and its selection criteria; the invite list is
   built automatically.
6. **Events → activate** the event, then use **Attendance** to mark people in.

---

## Schema changes

There is no ORM-style diffing — each change is a new sequential migration:

1. add `application/migrations/003_*.php` (`004_*.php`, …) with `up()` and a
   working `down()`;
2. bump `migration_version` in `application/config/migration.php`;
3. run `php index.php migrate`.

`php index.php migrate version 0` rolls everything back;
`php index.php migrate version N` moves to a specific version.

---

## Notes

* `application/config/config.php` has an empty `encryption_key`. Set one
  (`php -r "echo bin2hex(random_bytes(16));"`) before using encrypted cookies or
  the database session driver.
* Set `CI_ENV=production` (env var or `.env`) in production to hide errors and
  database debug output.
