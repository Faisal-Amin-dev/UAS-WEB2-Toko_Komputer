# AGENTS.md — UAS-WEB2-Toko_Komputer

CodeIgniter 3 (not CI4). PHP >=5.3.7. MySQL via `mysqli`. No build tools, no tests, no linter.

## Setup

- **Base URL**: `http://localhost/UAS-WEB2-Toko_Komputer/` (set in `application/config/config.php:26`)
- **Database**: `db_toko_komputer`, user `root`, no password (`application/config/database.php:76-96`)
- **Schema**: [`database.sql`](../database.sql) di root repo — import via phpMyAdmin atau CLI (`mysql -u root < database.sql`).
- **Clean URLs**: `.htaccess` rewrites work via Apache `mod_rewrite` (already configured).
- **`composer.json`** uses `sed -i` in post-install scripts — **will fail on Windows**. `vendor/` is gitignored and not needed for runtime.

## Architecture

| Layer | Location | Notes |
|-------|----------|-------|
| Entry point | `index.php` | CI3 front controller |
| Config | `application/config/` | Key files: `config.php`, `database.php`, `routes.php`, `autoload.php` |
| Controllers | `application/controllers/` | `Auth`, `Dashboard`, `Kategori`, `Produk`, `Users`, `Welcome` |
| Models | `application/models/` | `M_auth`, `M_kategori`, `M_prod`uk |
| Views | `application/views/` | `auth/`, `dashboard/`, `kategori/`, `produk/`, `users/` |

**Autoloaded**: `database`, `session`, `form_validation` (libraries); `url`, `form`, `file` (helpers).

## Auth & Authorization

- **Login**: `Auth::login_process()` → `password_verify()` against hashed passwords in `users` table. Session key: `logged_in`.
- **Roles**: `admin` and `petugas`. Controllers that guard CUD actions call a private `_is_admin()` method that checks `$this->session->userdata('role') !== 'admin'`.
  **Dashboard** is accessible to both roles. **Users** controller blocks non-admin entirely in constructor.
- **Flash messages**: Success → `$this->session->set_flashdata('pesan', ...)`. Error → `$this->session->set_flashdata('error', ...)`.
- **Session**: files driver, 7200s expiration, cookie `ci_session`.
- **Encryption key**: `admin123` (hardcoded). CSRF: disabled.

## Known Issues

- **`application/views/users/v_list.php` does not exist** — `Users::index()` loads `users/v_list` but the file is missing. Must be created.
- `M_prod`uk has a duplicate `get_all_kategori()` method (same as `M_kategori`).

## Conventions

- Controllers that require auth check `$this->session->userdata('logged_in')` in constructor, redirect to `auth` on failure.
- Admin-only CUD actions use `$this->_is_admin()`.
- Views use Bootstrap 4.6.2 via CDN (`cdn.jsdelivr.net/npm/bootstrap@4.6.2`). No local CSS/JS.
- Model queries follow CI3 Query Builder (`$this->db->get()`, `$this->db->insert()`, etc.).
- Image uploads: `assets/uploads/prod`uk/`, allowed `jpg|jpeg|png`, max 2MB.
  Old images (except `default.jpg`) are deleted on update/delete.

## Git

- **Branch**: `fitur-core-crud`
- **Origin**: `https://github.com/Faisal-Amin-dev/UAS-WEB2-Toko_Komputer`
