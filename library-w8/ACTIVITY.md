# Library Circulation Desk

Standalone Laravel project for the Week 8 self-directed activity.

## Run

From PowerShell:

```powershell
cd C:\kelgadiano\library-w8
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve --port=8001
```

Open `http://127.0.0.1:8001/books`. If Windows denies the storage symlink, create a directory junction instead:

```powershell
New-Item -ItemType Junction -Path public\storage -Target (Resolve-Path storage\app\public)
```

Run the automated checks with:

```powershell
php artisan test
```

The seeder creates 10 authors, 40 books, 30 members, and 1–3 loans per member. Member passwords are hashed; active loans do not assign one book to multiple members.

## Demo

1. Browse the catalogue and open a book to see its author, ISBN, cover, and availability.
2. Add a book with ISBN `978-0-306-40615-7`; confirm the saved ISBN is normalized to 13 digits and the cover receives a generated filename.
3. Try an invalid ISBN check digit, a year before 1450, or a GIF cover; confirm the form shows a summary and keeps the old input.
4. Edit a book without changing its ISBN, then replace its cover; the old cover should be removed only after the update succeeds.
5. Register a member with a date of birth at least 16 years ago and matching passwords. Confirm younger applicants or mismatched passwords are rejected.
6. Borrow an available book. Try borrowing it again, then try a different book for a member with three unreturned loans; both attempts should be rejected.

## Reflection

**Where should validation live?** Form Requests validate and normalize request data at the HTTP boundary: required fields, formats, ranges, foreign keys, and upload constraints. Business rules that depend on changing circulation state belong in the borrowing workflow and are rechecked inside a database transaction. Database constraints remain the final guard for uniqueness and foreign keys.

**Three upload risks without safety rules:**

- A disguised executable or active-content file could be uploaded and served as a trusted image.
- Oversized files could exhaust disk space or consume excessive processing resources.
- Trusting the client filename could allow path traversal, collisions, or overwriting another file.