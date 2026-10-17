# Library Accounts and Staff

## Self-Directed Activity

Laravel 13 with Breeze 2.4 (Blade). This is an independent project; its database is `library_w10`.

## Run with XAMPP

1. Start MySQL in XAMPP and create `library_w10` in phpMyAdmin.
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
Public registration creates a `member` account and its linked member profile automatically.
To replace generated author names in the browser, sign in as `librarian@example.com` (or admin),
open **Authors**, edit a name, and select **Save**. Updated author names appear in the book catalogue.
The 40 demo books have distinct, human-readable sample titles. Librarians and admins can change a
title at any time by opening **Books**, selecting a book, and choosing **Edit**.

## Demo accounts

All seeded passwords are `password`.

| Email | Role |
|---|---|
| `member@example.com` | member (linked to a member profile) |
| `librarian@example.com` | librarian |
| `admin@example.com` | admin |

The seeder creates 10 authors, 40 books (one reference-only), 30 members, and 1–3 loans per member
with about 20% still unreturned in the `book_member` loan pivot table. Members can borrow circulating books and see only their loans.
Reference books cannot be borrowed. Librarians manage books and mark loans returned. Admins manage
user roles; an admin cannot demote their own account.

## Check

```powershell
php artisan test
php artisan route:list
```

## Manual role matrix

Status codes below are for a logged-in account except the guest row.

| Account | Browse / view book | Borrow circulating | Borrow reference | My loans | Open desk | Mark returned | Manage books | Change role |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| Guest | 200 | 302 | 302 | 302 | 302 | 302 | 302 | 302 |
| Member | 200 | 302 | 403 | 200 | 403 | 403 | 403 | 403 |
| Librarian | 200 | 403 | 403 | 403 | 200 | 302 | 200 | 403 |
| Admin | 200 | 403 | 403 | 403 | 200 | 302 | 200 | 302* |

`*` Admin role updates redirect after success; changing the signed-in admin's own role to `member`
or `librarian` returns 403.
