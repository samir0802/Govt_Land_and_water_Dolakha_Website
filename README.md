# District Government Office Website (Dholakha) - PHP MVC + CMS

A complete district-level government office portal inspired by Nepal government district websites, with a public website and admin CMS.

## 1) Project Folder Structure

```text
/public
  /assets
    /css
    /js
    /images
      /uploads
        /gallery
        /downloads
        /hero
  index.php
/index.php
/app
  /controllers
  /models
  /views
    /partials
    /pages
    /admin
/admin
  index.php
/config
  config.php
  database.php
/database
  schema.sql
/storage
  /logs
```

## 2) Database Schema (MySQL)

Import `database/schema.sql`.

Core tables with `id`, `created_at`, `updated_at`:
- `users`
- `notices`
- `downloads`
- `services`
- `employees`
- `gallery`
- `contact_messages`

Additional table:
- `publications` (for the Publications section)

## 3) Backend Architecture (Structured MVC)

- **Entry points:** `public/index.php` (public), `admin/index.php` (CMS)
- **Controllers:** request handling and routing by `page` + `action`
- **Models:** PDO prepared statements for SQL injection protection
- **Views:** Bootstrap + PHP templates for modular rendering
- **Config:** central settings in `config/config.php`

### Security Implemented
- Password hashing (`password_hash` / `password_verify`)
- SQL injection protection via prepared statements
- Session-based authentication for admin routes
- Upload constraints configurable in `config/config.php` (`type`, `size`)

## 4) Homepage HTML Sections

Implemented components:
- Nepal government-style header
- responsive navigation with dedicated pages for Introduction, Services, Publications, Downloads, Gallery, Contact
- hero slider
- latest notices
- office introduction
- services overview
- publications section
- downloads section
- gallery preview
- contact info + footer links

Main view file: `app/views/pages/home.php`

## 5) Admin Dashboard (CMS)

Admin modules:
- Dashboard overview
- Notices manager (full CRUD)
- Downloads manager (scaffold)
- Services manager (scaffold)
- Employees manager (scaffold)
- Gallery manager (scaffold)
- Settings (scaffold)

Login route: `/admin/index.php?page=login`

## 6) CRUD Example (Notices)

Implemented full CRUD:
- List: `/admin/index.php?page=notices`
- Create form: `?page=notices&action=create`
- Store: POST `?page=notices&action=create`
- Edit form: `?page=notices&action=edit&id={id}`
- Update: POST `?page=notices&action=update&id={id}`
- Delete: POST `?page=notices&action=delete&id={id}`

Files:
- `app/controllers/AdminNoticeController.php`
- `app/models/Notice.php`
- `app/views/admin/notices/index.php`
- `app/views/admin/notices/form.php`

## 7) Deployment Instructions (Shared Hosting Ready)

1. Upload files to your hosting account.
2. You can run from project root (`index.php`) for subfolder portability, or set web root directly to `public/` for production.
3. Create MySQL database and import `database/schema.sql`.
4. Update DB credentials in `config/config.php` or set env vars (`DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`).
5. If the configured database does not exist, the app will attempt to create it automatically. If your hosting account does not allow that, create the database manually and then import `database/schema.sql`.
6. Ensure these folders are writable if you extend uploads/logging:
   - `public/assets/images/uploads`
   - `storage/logs`
7. Login to admin using seed account:
   - username: `admin`
   - password: `Admin@123`
8. Change admin password immediately after first login.

---

## Notes for Extension

To complete all CRUD modules, copy the Notice pattern:
1. Create a model with list/find/create/update/delete.
2. Create admin controller methods.
3. Add route handling in `admin/index.php`.
4. Build admin view pages for table + form.
5. Add file upload validation for downloads/gallery in controller methods.


## URL Portability Notes

- Use `url('path')` for all links/forms/redirect destinations.
- Use `asset('css/style.css')` for static files.
- Set `APP_URL` in environment for explicit domain/subfolder control; otherwise base URL auto-detection is used.


## Password Hash Generator

- Web generator: Admin → Settings (`/admin/index.php?page=settings`)
- CLI generator: `php scripts/generate_password_hash.php 'YourPassword'`
- Best practice: generate a fresh hash per deployment/user instead of reusing a default shared hash in production.
