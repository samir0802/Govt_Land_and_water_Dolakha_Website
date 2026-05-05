# Nepal E-Government CMS (PHP MVC)

Production-ready, reusable CMS for Nepal government office websites (public portal + admin dashboard) using PHP MVC, PDO, Bootstrap 5, and MySQL.

## Folder Structure

```text
/public
  index.php
  /assets
    /css
    /js
    /images
      /uploads
        /gallery/{album_id}/images
        /downloads
        /employees
/admin
  index.php
/app
  /controllers
  /models
  /views
    /pages
    /admin
    /partials
/config
  config.php
  database.php
/database
  schema.sql
/storage
  /logs
```

## Database Schema

Tables included:
- users
- notices
- downloads
- services
- employees
- gallery_albums
- gallery_items
- publications
- contact_messages
- site_settings

All tables include: `id`, `created_at`, `updated_at`.

## Config + Helpers

- Base URL auto-detect and env fallback (`APP_URL`)
- No hardcoded `/admin` or `/public` links in controllers/views
- Global helpers:
  - `url($path)`
  - `redirect($path)`
  - `asset($path)`
  - `setting($key, $default)`

## Routing

- Public: `public/index.php?page=...`
- Admin: `admin/index.php?page=...`

## CMS Modules

- Login/Auth (session + password hash verify)
- Notices (full CRUD)
- Downloads (upload PDF + delete)
- Services (full CRUD)
- Employees (create + delete with photo upload)
- Gallery (albums + media upload)
- Settings (persisted in `site_settings`)

## XAMPP Deployment

1. Copy project into `htdocs/project-name`.
2. Import `database/schema.sql` into MySQL.
3. Configure env vars (optional): `APP_URL`, `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`.
4. Ensure writable upload paths:
   - `public/assets/images/uploads/`
5. Open:
   - Public: `http://localhost/project-name/public/index.php`
   - Admin: `http://localhost/project-name/admin/index.php?page=login`
6. Seed admin:
   - username: `admin`
   - password: `Admin@123`

## XAMPP Validation Checklist

- Login works
- Notice CRUD works
- PDF/image upload works
- Gallery album images render
- Settings values reflect on frontend
- No broken links via URL helpers
