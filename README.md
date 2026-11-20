# Hapag: Restaurant Booking System (Laravel)

Features: table reservations (Create/Read/Update/Delete), automatic table assignment, deposit payment records inside a
database **transaction**, confirmation **email**, staff admin panel (reservations + tables CRUD).

This repo contains only the custom files. You copy them into a fresh Laravel project (Part 1), then push to GitHub (Part 2) and host (Part 3).

## Part 1: Build locally (do this tonight)

Requirements: PHP 8.2+, Composer, XAMPP (MySQL) or any MySQL.

1. `composer create-project laravel/laravel hapag`
2. Copy everything from this zip into the `hapag` folder (merge/overwrite): `app/`, `config/`, `database/`, `resources/`, `routes/`.
   Also copy `deploy/` and `README.md` (optional, handy to keep in GitHub).
3. In phpMyAdmin create an empty database named `hapag`.
4. Open `hapag/.env` and change the values shown in `deploy/env.local.example` (DB, SESSION_DRIVER=file, mail, ADMIN_PASSWORD).
5. In the `hapag` folder run:
   ```
   php artisan migrate
   php artisan db:seed
   php artisan serve
   ```
6. Open http://127.0.0.1:8000, choose a restaurant, and make a booking. The selected restaurant is saved with the reservation and included in the confirmation email.
7. To see the message in an inbox, configure the `MAIL_*` values in `.env` with an SMTP provider such as Mailtrap, Gmail SMTP with an app password, or your hosting provider. Then book using the inbox address you want to receive the confirmation.
   Staff panel: http://127.0.0.1:8000/admin/login (password = ADMIN_PASSWORD).

## Part 2: GitHub

1. Create an empty repo on github.com (no README).
2. In the `hapag` folder:
   ```
   git init
   git add .
   git commit -m "Restaurant booking system"
   git branch -M main
   git remote add origin https://github.com/YOUR-USERNAME/hapag.git
   git push -u origin main
   ```
   Laravel's default `.gitignore` already excludes `.env` and `vendor/`, so no passwords get uploaded.

## Part 3: Host on InfinityFree

InfinityFree has no SSH or Composer, so you upload the `vendor` folder yourself and import the database.

1. Sign up at infinityfree.com, create a hosting account and note your domain (e.g. `yoursite.rf.gd`).
2. Control Panel > **MySQL Databases**: create a database (e.g. `hapag`). Note the host (`sqlXXX.infinityfree.com`), db name, username (`if0_...`) and password.
3. Export your local database: phpMyAdmin (local) > `hapag` > Export > Quick > SQL. Skip the `sessions`/`cache` tables if you want; they are not needed.
4. InfinityFree phpMyAdmin > select your database > Import > choose the .sql file. This gives you the tables **and** the seeded tables.
5. On your computer, in the `hapag` folder, run `php artisan key:generate` (already done if `.env` has APP_KEY). Copy the `APP_KEY=` line.
6. Prepare `.env` for production using `deploy/env.production.example` (fill DB details, APP_KEY, APP_URL, APP_DEBUG=false). Save it as `.env`.
7. Upload with FileZilla (details in InfinityFree > FTP Details) or the online File Manager. Everything goes inside `htdocs/`:
   - Create `htdocs/laravel/` and upload **all project files into it**: `app`, `bootstrap`, `config`, `database`, `resources`, `routes`, `storage`, `vendor`, `artisan`, `composer.json`, and your production `.env`.
     (`vendor` has thousands of files. Zip it, upload the zip and extract in File Manager, or just let FTP run.)
   - Upload the **contents** of the project's `public/` folder straight into `htdocs/` (the `.htaccess` file and `favicon.ico`, etc.).
   - Replace `htdocs/index.php` with `deploy/index.php` from this repo.
   - Upload `deploy/laravel-folder.htaccess` into `htdocs/laravel/` and rename it to `.htaccess`. This blocks the web from reading your `.env`.
8. Make sure `htdocs/laravel/storage` (and subfolders) and `htdocs/laravel/bootstrap/cache` exist. Set permissions to 775 if you get a permission error (FileZilla: right-click > File permissions).
9. Visit your domain. Book a table, then log in at `/admin/login`.

## Troubleshooting

- **500 error**: set `APP_DEBUG=true` temporarily in the host `.env` and reload to see the message. Look in `htdocs/laravel/storage/logs/laravel.log`.
- **"No application encryption key"**: APP_KEY missing in the host `.env`.
- **Database connection refused**: use the InfinityFree DB host (not `localhost`) and the full `if0_...` names.
- **Email**: InfinityFree commonly blocks outgoing SMTP on free accounts, so confirmation emails may not send there. The booking still succeeds (mail errors are caught and logged).
  Demo the email locally with Mailtrap. If you must send live, set `MAIL_MAILER=log` on the host and show the email text in `storage/logs/laravel.log`. Test this early, as it is the most likely thing to fail.
- **Pages 404 except home**: the `.htaccess` from `public/` wasn't uploaded to `htdocs/`.

## How the requirements are met (for your presentation)

| Requirement | Where |
|---|---|
| Laravel | whole project |
| Email configuration | `.env` MAIL_*, `app/Mail/ReservationConfirmed.php`, `resources/views/emails/reservation.blade.php` |
| Transaction processing | `BookingController@store` and `Admin\ReservationController@update` use `DB::transaction()` (table lock + reservation + payment; cancel + refund) |
| CRUD | Reservations: Create (public form), Read/Update/Delete (admin). Tables: full CRUD (admin) |
