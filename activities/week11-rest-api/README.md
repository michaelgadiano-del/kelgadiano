# Week 11 Lab Exercise 9 — RESTful Employee API

The root Laravel application now exposes a versioned, Sanctum-protected API for its employee resource. This lab uses the existing Employee Information System rather than creating duplicate models and tables.

## Run the API

From the repository root:

```powershell
php artisan migrate
php artisan serve
```

Register or use an existing account at `http://127.0.0.1:8000/register`. The API issues bearer tokens for those application accounts.

For a browser-based walkthrough without Postman, open `http://127.0.0.1:8000/api-playground`, sign in with that account, then use the employee form and list. Use the sign-out button to revoke the token before leaving the page.

## Endpoints

| Method | Endpoint | Authentication | Success |
|---|---|---|---|
| POST | `/api/v1/tokens` | No | `201` with a one-time bearer token |
| DELETE | `/api/v1/tokens/current` | Bearer token | `204` |
| GET | `/api/v1/employees` | Bearer token | `200`, paginated |
| POST | `/api/v1/employees` | Bearer token | `201` |
| GET | `/api/v1/employees/{id}` | Bearer token | `200` |
| PUT/PATCH | `/api/v1/employees/{id}` | Bearer token | `200` |
| DELETE | `/api/v1/employees/{id}` | Bearer token | `204` |

Validation errors return JSON with status `422`; unauthenticated requests return `401`; missing employees return `404`. The employee resource explicitly selects the response fields and nests its department. Collection results eager-load departments and paginate at 10 employees per page.

### Get a token

```http
POST /api/v1/tokens
Content-Type: application/json
Accept: application/json
```

```json
{
  "email": "your-registered-email@example.test",
  "password": "your-password",
  "device_name": "postman"
}
```

Use the returned `token` as `Authorization: Bearer <token>` on employee requests. The plain token is shown only when created; keep it private and revoke it with `DELETE /api/v1/tokens/current` if it is lost.

### Create an employee

```http
POST /api/v1/employees
Authorization: Bearer <token>
Content-Type: application/json
Accept: application/json
```

```json
{
  "employee_number": "EMP-1001",
  "first_name": "Alex",
  "last_name": "Rivera",
  "email": "alex.rivera@example.test",
  "phone": "09171234567",
  "position": "Developer",
  "hire_date": "2024-01-15",
  "salary": 42000.5,
  "status": "Active",
  "department_id": 1
}
```

The `department_id` must exist in the database. Employee numbers and email addresses must be unique.

## Postman

Import [`Lab-9.postman_collection.json`](./Lab-9.postman_collection.json). Set the collection variables `email` and `password` to the account registered in the app, and set `departmentId` to an existing department ID. Run **Issue token** first; its test script saves the token automatically. Then run the requests in order: unauthenticated `401`, invalid data `422`, list `200`, create `201`, show `200`, update `200`, delete `204`, and revoke token `204`. The create request saves `employeeId` for the later requests. The collection uses a timestamp in the employee number and email to avoid collisions between runs.

## Automated checks

```powershell
php artisan test tests\Feature\EmployeeApiTest.php
```

The feature tests verify token issuance and revocation, unauthenticated access, paginated resource output, CRUD status codes, unique-value handling on update, and JSON validation errors.
