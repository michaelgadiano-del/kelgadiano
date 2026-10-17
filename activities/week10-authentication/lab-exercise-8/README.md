# WEBDEV3 — Web Framework Laravel Development

## Lab Exercise 8 — Auth-Protected Course Catalogue

Laravel 13 with Breeze 2.4 (Blade). This is an independent project; its database is `auth_lab_w10`.

## Run with XAMPP

1. Start MySQL in XAMPP and create `auth_lab_w10` in phpMyAdmin.
2. Copy `.env.example` to `.env`, then set the XAMPP MySQL password in `DB_PASSWORD` if it is not
   blank.
3. Run:

```powershell
composer install
php artisan key:generate
php artisan config:clear
php artisan migrate:fresh --seed
npm install
npm run build
php artisan serve
```

Open `http://127.0.0.1:8000`. Run `npm run dev` in a second terminal while editing views.
To change demo instructor display names in the browser, sign in as `admin@example.com`, open
`/admin`, edit an instructor's name, and select **Save**.

## Demo accounts

All seeded passwords are `password`.

| Email | Role |
|---|---|
| `admin@example.com` | admin |
| `ana@example.com` | instructor |
| `ben@example.com` | instructor |
| `carla@example.com` | student |

Ana owns one enrolled course and one inactive course. Ben owns three courses. Admin can manage every
course; instructors manage only their own; students can browse but cannot write; inactive courses are
visible only to their owner and admin; an owner cannot delete an enrolled course.

## Check

```powershell
php artisan test
php artisan route:list --path=courses
```

## Manual authorization checks

| Account | Check | Expected |
|---|---|---|
| Guest | Open active course / inactive course | 200 / 403 |
| Guest | Open `/courses/create` or `/admin` | 302 to login |
| Carla (student) | Open `/courses/create`, edit Ben's course, or `/admin` | 403 |
| Ana (instructor) | Edit her course / edit Ben's course | 200 / 403 |
| Ana (instructor) | Open her enrolled course | Edit link; no Delete link |
| Ana (instructor) | Delete her un-enrolled course | 302 to course list |
| Admin | Edit any course / open `/admin` | 200 / 200 |
