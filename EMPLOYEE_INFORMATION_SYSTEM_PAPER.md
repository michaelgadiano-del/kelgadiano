# Employee Information System

## Part 1: Project Overview and Scope

The Employee Information System is a simple web-based application designed to help an office or human resource staff manage employee records efficiently. The system allows authorized users to add, view, update, and delete employee information. This includes employee number, full name, email, phone number, job position, department, hire date, monthly salary, and employment status.

The purpose of the system is to centralize employee data in one organized database so that staff can access and maintain information more easily. It serves as a practical solution for small organizations that need a faster and more reliable way to manage employee records without using complicated systems.

This project was developed using Laravel, which provides a structured framework for building web applications. The system uses migrations to create the database tables, models to represent the data, controllers to handle business logic, routes to connect URLs to actions, and Blade views to display the user interface. The application also includes validation rules to keep the stored data accurate and consistent.

The system is intended for administrative users who manage employee records. It helps maintain data integrity and reduces errors caused by duplicate or incomplete entries.

### System Scope
- Store employee profile information
- Assign employees to departments
- Track employee status such as Active, On Leave, and Inactive
- Maintain contact details and monthly salary records
- Provide employee CRUD operations
- Protect employee routes using middleware

---

## Part 2: Database Table Structure

The database design of the system is structured to separate department information from employee information. This keeps the data organized and reduces duplication. The main tables used in the system are the departments table and the employees table.

### Data Dictionary

| Table Name | Column Name | Data Type | Constraint | Description |
|---|---|---|---|---|
| departments | id | Integer | Primary Key | Unique department identifier |
| departments | name | String | Required | Department name |
| departments | code | String | Nullable / Unique | Short department code |
| employees | id | Integer | Primary Key | Unique employee identifier |
| employees | employee_number | String | Unique | Employee code or number |
| employees | first_name | String | Required | Employee first name |
| employees | last_name | String | Required | Employee last name |
| employees | email | String | Unique | Employee email address |
| employees | phone | String | Nullable | Employee contact number |
| employees | position | String | Required | Job title or position |
| employees | hire_date | Date | Required | Date when the employee was hired |
| employees | salary | Decimal | Required | Monthly salary of the employee |
| employees | status | Enum | Required | Employment status: Active, On Leave, Inactive |
| employees | department_id | Integer | Foreign Key | Identifies which department the employee belongs to |
| employees | created_at | Timestamp | Nullable | Date and time the record was created |
| employees | updated_at | Timestamp | Nullable | Date and time the record was updated |

### Relationship Overview

- One Department can have many Employees.
- Each Employee belongs to one Department.
- The department_id field connects employees to their assigned department.

### Architectural Diagram

Employee Information System

[User / Admin]
        |
        v
[Browser / Web Interface]
        |
        v
[Routes + Controller Logic]
        |
        v
[Model Layer]
        |
        v
[Database Tables]
  - departments
  - employees

This structure allows data to move from the user interface to the database in a clear and organized way.

---

## Part 3: Route and Security Summary

Laravel routes are used to connect URLs to controller methods. In this project, route definitions are used to allow the user to access employee-related pages and actions. The routes represent the main actions of the system such as listing employees, creating a new employee, updating an employee, and deleting an employee record.

### Route Summary Table

| URL | HTTP Method | Controller Action | Middleware Protection |
|---|---|---|---|
| /login | GET/POST | AuthController@showLogin / login | Guest / Throttled |
| /register | GET/POST | AuthController@showRegister / register | Guest / Throttled |
| /logout | POST | AuthController@logout | Authenticated |
| /employees | GET/POST | EmployeeController@index / store | Authenticated |
| /employees/create | GET | EmployeeController@create | Authenticated |
| /employees/{employee} | GET | EmployeeController@show | Authenticated |
| /employees/{employee}/edit | GET | EmployeeController@edit | Authenticated |
| /employees/{employee} | PUT/PATCH | EmployeeController@update | Authenticated |
| /employees/{employee} | DELETE | EmployeeController@destroy | Authenticated |

### Security Discussion

The system uses Laravel authentication to control access to employee-related pages. Users register with a name, unique username, email, and password, then sign in with their username and password. Passwords are hashed, login attempts are throttled, and employee routes require an authenticated session.

This security feature is important because employee information is sensitive and should not be accessed by unauthorized persons.

---

## Part 4: Form Validation Rules Matrix

Validation is an important part of the project because it ensures that the information entered into the system is correct, complete, and suitable for storage. Laravel provides server-side validation, which checks each field before the record is saved to the database.

### Validation Rules

| Field | Validation Rule |
|---|---|
| employee_number | Required, string, maximum 20 characters, unique |
| first_name | Required, string, maximum 60 characters |
| last_name | Required, string, maximum 60 characters |
| email | Required, valid email format, unique |
| phone | Nullable, string, maximum 20 characters |
| position | Required, string, maximum 80 characters |
| hire_date | Required, valid date |
| salary | Required, numeric, minimum 0 |
| status | Required, valid value: Active, On Leave, Inactive |
| department_id | Required, must exist in departments table |

### Validation Importance

These rules help prevent duplicate employee numbers, empty required fields, invalid email addresses, missing department assignment, and incorrect salary values. This improves the quality of the collected data and makes the system more reliable in a real office environment.

---

## Part 5: User Interface Screenshots and Demo Flow

The user interface of the system is built using Blade templates. These pages are simple, easy to understand, and designed for quick employee management.

### Screenshots to Include in the Final Report

1. Employee List Page
   - Shows the employee table with columns such as Employee Number, Employee Name, Position, Department, Status, and Actions.
   - Includes Add Employee button.
   - This page is the main dashboard of the system.

2. Add Employee Form
   - Contains fields for employee number, first name, last name, email, phone, position, hire date, salary, status, and department.
   - Shows required fields and validation messages when data is incomplete or invalid.

3. Edit Employee Form
   - Displays the selected employee record in editable fields.
   - Lets the admin update employee details.

4. Employee Details Page
   - Shows all information related to a specific employee.
   - Useful for viewing full profile details before editing or deleting the record.

### Demo Flow

The operation of the system follows a simple flow:

1. The admin opens the employee list page.
2. The user clicks Add Employee to create a new record.
3. The form is filled with valid data and submitted.
4. Laravel validates the data before saving.
5. The database stores the record successfully.
6. The user can view, update, or delete the employee from the list.

This CRUD flow is the core functionality of the system and demonstrates how the application works in practice.

### Annotated UI Notes

- Add Employee button: used to create a new employee record
- Employee Name link: opens the employee details page
- Edit button: allows modification of selected employee data
- Delete button: removes the employee record from the database
- Success message: confirms that the action was completed
- Validation message: informs the user about incorrect or incomplete input

---

## Short Oral Defense Script

“Good morning, ma’am/sir. Our project is an Employee Information System. Users register and sign in with a username and password before managing employee information. The system allows authenticated users to add new employees, view their records, update details, and delete records when necessary. The project is built using Laravel, and the database structure is created using migrations. The main tables are departments and employees, which are connected through a department_id relationship.”

“We also used models, controllers, routes, and Blade views to complete the CRUD functions. The validation rules ensure that required fields are not empty and that duplicate or incorrect data is not saved. Laravel authentication protects the employee routes, while hashed passwords and login throttling help secure accounts.”

“In conclusion, the Employee Information System is a practical and functional Laravel application that demonstrates the key concepts of the subject, including database design, routing, middleware, form validation, and CRUD operations.”

---

## Conclusion

The Employee Information System is a suitable project for the midterm requirement because it demonstrates multiple Laravel concepts in one working application. It shows how a simple information system can be designed, validated, protected, and displayed through a web interface. The system is practical, easy to understand, and directly aligned with the approved project topic.

This documentation provides a clear explanation of how the system works without including raw source code. It focuses instead on system design, database structure, routes, validation rules, and application functionality as required by the assignment.
