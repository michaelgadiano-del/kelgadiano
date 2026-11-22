# Week 11 Lab 9 — Simple Postman Demo

This guide is written as a step-by-step script for the live API demonstration.

## Before the demo

1. In VS Code, open the project terminal in `C:\kelgadiano`.
2. Start the server with `php artisan serve`. Leave the terminal running.
3. Open Postman and import [`Lab-9.postman_collection.json`](./Lab-9.postman_collection.json).
4. Open the collection's variables and set:
   - `email`: the email address of your Employee Information System account.
   - `password`: that account's password. Enter it in Postman only; do not send or show it to anyone.
   - `departmentId`: an existing department ID. The seeded departments normally use IDs 1–4.
   - `baseUrl`: leave as `http://127.0.0.1:8000` if that is the URL shown by `php artisan serve`.
5. Save the variables. Do not share screenshots that show your password or token.

## Run the requests in this order

Run each request with **Send** and check both the status code and response.

| Order | Request in the collection | Expected | What to say |
|---:|---|---:|---|
| 1 | **Issue token** | `201 Created` | “I authenticate with my account and receive a Sanctum bearer token. The token is returned only when it is created.” |
| 2 | **401 - Employee list without token** | `401 Unauthorized` | “Protected employee endpoints reject requests without a token.” |
| 3 | **422 - Invalid employee** | `422 Unprocessable Content` | “The API validates input and returns field errors as JSON.” |
| 4 | **200 - List employees** | `200 OK` | “The list is paginated and each employee includes a shaped department resource.” |
| 5 | **201 - Create employee** | `201 Created` | “A successful create returns the new employee and its ID.” |
| 6 | **200 - Show employee** | `200 OK` | “The collection saved that ID, so this request fetches the new record.” |
| 7 | **200 - Update employee** | `200 OK` | “The employee is updated; its existing employee number and email remain valid.” |
| 8 | **204 - Delete employee** | `204 No Content` | “The demo employee is deleted successfully; a 204 response has no body.” |
| 9 | **204 - Revoke current token** | `204 No Content` | “The current token is revoked and can no longer authorize requests.” |

The **Issue token** request saves the token automatically. The create request saves the new employee ID for the show, update, and delete requests. Run those requests in order; do not run the revoke request until the end.

The delete request permanently removes the employee created in step 5. It does not delete the other employees.

## If something does not work

- **Connection refused:** confirm the Laravel server is still running and check its URL and port. Update `baseUrl` if needed.
- **Token request returns `401`:** check the account email and password in Postman. Do not use an employee's email unless it is also the registered user account email.
- **Create returns `422` for `department_id`:** set `departmentId` to an existing department ID.
- **Employee number or email already exists:** the collection uses a timestamp to generate values; send the create request again after the previous run's employee has been deleted.
- **Request after revoking returns `401`:** this is expected. Issue a new token to continue.

## Browser alternative

The [Employee API Playground](http://127.0.0.1:8000/api-playground) can demonstrate sign-in, listing, creation, and deletion in the browser. The assignment specifically asks for a Postman collection, so use the Postman request sequence above for the graded Postman run-through.
