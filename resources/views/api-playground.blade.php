<x-layout title="Employee API Playground">
    <style>
        .api-playground { width: min(1000px, calc(100% - 40px)); margin: 0 auto; padding: 38px 0 56px; }
        .api-hero { position: relative; overflow: hidden; margin-bottom: 24px; border-radius: 10px; padding: clamp(24px, 5vw, 42px); background: #183d35; color: #f4f5ed; box-shadow: 0 14px 34px rgba(28, 48, 43, .14); }
        .api-hero::after { position: absolute; right: -44px; bottom: -108px; width: 260px; height: 260px; border: 1px solid rgba(255,255,255,.12); border-radius: 50%; box-shadow: 0 0 0 28px rgba(255,255,255,.035), 0 0 0 58px rgba(255,255,255,.025); content: ""; pointer-events: none; }
        .api-eyebrow { margin: 0 0 8px; color: #e3b653; font-size: .75rem; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; }
        .api-hero h1 { margin: 0; color: #fff; font-family: Georgia, "Times New Roman", serif; font-size: clamp(1.8rem, 4vw, 2.5rem); font-weight: 400; line-height: 1.15; }
        .api-hero-copy { max-width: 640px; margin: 12px 0 0; color: #d3ded7; }
        .api-layout { display: grid; gap: 20px; }
        .api-card { min-width: 0; overflow: hidden; border: 1px solid #d4dfd8; border-radius: 8px; background: #fbfcfb; box-shadow: 0 10px 28px rgba(28, 48, 43, .07); }
        .api-card-heading { display: flex; align-items: flex-start; gap: 13px; padding: 20px 22px 16px; border-bottom: 1px solid #e5ebe7; }
        .api-step { display: grid; width: 32px; height: 32px; flex: 0 0 32px; place-items: center; border-radius: 50%; background: #eaf2ed; color: #176b59; font-size: .85rem; font-weight: 800; }
        .api-card-heading h2 { margin: 1px 0 0; color: #183d35; font-size: 1.15rem; }
        .api-card-heading p { margin: 4px 0 0; color: #718078; font-size: .88rem; }
        .api-card-body { padding: 20px 22px 22px; }
        .api-form-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
        .api-field { display: grid; align-content: start; gap: 6px; color: #344740; font-size: .88rem; font-weight: 700; }
        .api-field input, .api-field select { width: 100%; min-height: 43px; border: 1px solid #cbd7d0; border-radius: 4px; padding: 9px 11px; background: #fff; color: #1c302b; font: inherit; font-size: .92rem; font-weight: 400; }
        .api-field input:focus, .api-field select:focus { border-color: #176b59; outline: 0; box-shadow: 0 0 0 3px rgba(23, 107, 89, .13); }
        .api-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }
        .api-button { display: inline-flex; min-height: 42px; align-items: center; justify-content: center; gap: 8px; border: 1px solid transparent; border-radius: 4px; padding: 9px 15px; background: #176b59; color: #fff; font: inherit; font-size: .9rem; font-weight: 700; cursor: pointer; transition: background .15s ease, transform .15s ease; }
        .api-button:hover { transform: translateY(-1px); background: #105342; }
        .api-button:focus-visible { outline: 3px solid rgba(23, 107, 89, .25); outline-offset: 2px; }
        .api-button--secondary { border-color: #cbd7d0; background: #fff; color: #244b40; }
        .api-button--secondary:hover { background: #edf3ef; }
        .api-button--danger { border-color: #e4c9c5; background: #fff; color: #9e3f36; }
        .api-button--danger:hover { background: #fcf0ee; }
        .api-status { min-height: 24px; margin: 15px 0 0; border-radius: 4px; padding: 0; color: #596961; font-size: .9rem; white-space: pre-wrap; }
        .api-status.is-success, .api-status.is-error { padding: 10px 12px; }
        .api-status.is-success { background: #edf6ef; color: #23633b; }
        .api-status.is-error { background: #fff0ee; color: #a33e34; }
        .api-table-wrap { overflow-x: auto; border: 1px solid #e0e7e2; border-radius: 5px; }
        .api-table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        .api-table th { padding: 12px 14px; background: #183d35; color: #f4f5ed; font-size: .78rem; font-weight: 700; letter-spacing: .04em; text-align: left; text-transform: uppercase; }
        .api-table td { padding: 11px 14px; border-bottom: 1px solid #e5ebe7; color: #344740; font-size: .88rem; }
        .api-table tbody tr:last-child td { border-bottom: 0; }
        .api-table tbody tr:hover { background: #f2f7f3; }
        .api-empty { padding: 24px !important; color: #718078 !important; text-align: center; }
        [hidden] { display: none !important; }
        @media (max-width: 700px) {
            .api-playground { width: min(100% - 28px, 1000px); padding-top: 24px; }
            .api-form-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .api-card-heading, .api-card-body { padding-right: 16px; padding-left: 16px; }
        }
        @media (max-width: 480px) {
            .api-form-grid { grid-template-columns: 1fr; }
            .api-actions { align-items: stretch; flex-direction: column; }
            .api-button { width: 100%; }
        }
    </style>

    <section class="api-playground">
        <header class="api-hero">
            <p class="api-eyebrow">Developer tools · REST API</p>
            <h1>Employee API Playground</h1>
            <p class="api-hero-copy">Sign in to securely explore the employee API. Create records, browse the live directory, and remove records from one simple workspace.</p>
        </header>

        <div class="api-layout">
            <section class="api-card" aria-labelledby="account-heading">
                <div class="api-card-heading">
                    <span class="api-step" aria-hidden="true">1</span>
                    <div>
                        <h2 id="account-heading">Connect your account</h2>
                        <p>Use your Employee Information System account to authorize this session.</p>
                    </div>
                </div>
                <div class="api-card-body">
                    <form id="login-form">
                        <div class="api-form-grid">
                            <label class="api-field">Email address
                                <input name="email" type="email" autocomplete="username" placeholder="you@example.com" required>
                            </label>
                            <label class="api-field">Password
                                <input name="password" type="password" autocomplete="current-password" placeholder="Enter your password" required>
                            </label>
                            <label class="api-field">Device name
                                <input name="device_name" value="browser-playground" maxlength="80" required>
                            </label>
                        </div>
                        <div class="api-actions">
                            <button class="api-button" type="submit">Connect to API</button>
                            <button class="api-button api-button--danger" id="logout-button" type="button" hidden>Sign out and revoke token</button>
                        </div>
                    </form>
                    <p id="account-status" class="api-status" role="status">Not connected. Your API token stays in this page's memory and is not saved in browser storage.</p>
                </div>
            </section>

            <section id="employee-section" class="api-card" hidden aria-labelledby="employee-heading">
                <div class="api-card-heading">
                    <span class="api-step" aria-hidden="true">2</span>
                    <div>
                        <h2 id="employee-heading">Manage employees</h2>
                        <p>Create a record or load the latest employee directory from the API.</p>
                    </div>
                </div>
                <div class="api-card-body">
                    <form id="employee-form">
                        <div class="api-form-grid">
                            <label class="api-field">Employee number
                                <input name="employee_number" maxlength="20" placeholder="EMP-1001" required>
                            </label>
                            <label class="api-field">First name
                                <input name="first_name" maxlength="60" required>
                            </label>
                            <label class="api-field">Last name
                                <input name="last_name" maxlength="60" required>
                            </label>
                            <label class="api-field">Email address
                                <input name="email" type="email" placeholder="employee@example.com" required>
                            </label>
                            <label class="api-field">Phone
                                <input name="phone" maxlength="20" placeholder="Optional">
                            </label>
                            <label class="api-field">Position
                                <input name="position" maxlength="80" placeholder="e.g. IT Specialist" required>
                            </label>
                            <label class="api-field">Hire date
                                <input name="hire_date" type="date" required>
                            </label>
                            <label class="api-field">Monthly salary
                                <input name="salary" type="number" min="0" step="0.01" placeholder="0.00" required>
                            </label>
                            <label class="api-field">Employment status
                                <select name="status" required>
                                    <option>Active</option>
                                    <option>On Leave</option>
                                    <option>Inactive</option>
                                </select>
                            </label>
                            <label class="api-field">Department
                                <select name="department_id" required>
                                    <option value="">Select a department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }} ({{ $department->code }})</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="api-actions">
                            <button class="api-button" type="submit">Create employee · POST</button>
                            <button class="api-button api-button--secondary" id="refresh-button" type="button">Refresh directory · GET</button>
                        </div>
                    </form>
                    <p id="api-status" class="api-status" role="status"></p>
                    <div class="api-table-wrap">
                        <table class="api-table">
                            <thead>
                                <tr><th>ID</th><th>Employee</th><th>Email</th><th>Position</th><th>Department</th><th>Actions</th></tr>
                            </thead>
                            <tbody id="employee-list">
                                <tr><td class="api-empty" colspan="6">Connect your account to load employees.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <script>
        let apiToken = null;
        const accountStatus = document.getElementById('account-status');
        const apiStatus = document.getElementById('api-status');
        const employeeSection = document.getElementById('employee-section');
        const employeeList = document.getElementById('employee-list');

        async function apiRequest(path, options = {}) {
            const response = await fetch(path, {
                ...options,
                headers: {
                    Accept: 'application/json',
                    ...(options.body ? { 'Content-Type': 'application/json' } : {}),
                    ...(apiToken ? { Authorization: `Bearer ${apiToken}` } : {}),
                    ...options.headers,
                },
            });
            const body = response.status === 204 ? null : await response.json();

            if (!response.ok) {
                const errors = body?.errors ? Object.values(body.errors).flat().join('\n') : body?.message;
                throw new Error(errors || `HTTP ${response.status}`);
            }

            return body;
        }

        function setStatus(element, message, isError = false) {
            element.textContent = message;
            element.className = `api-status ${isError ? 'is-error' : 'is-success'}`;
        }

        function addCell(row, value) {
            const cell = document.createElement('td');
            cell.textContent = value ?? '—';
            row.appendChild(cell);
        }

        async function loadEmployees() {
            const result = await apiRequest('/api/v1/employees');
            employeeList.replaceChildren();

            if (result.data.length === 0) {
                const row = document.createElement('tr');
                const cell = document.createElement('td');
                cell.colSpan = 6;
                cell.className = 'api-empty';
                cell.textContent = 'No employee records found.';
                row.appendChild(cell);
                employeeList.appendChild(row);
            }

            for (const employee of result.data) {
                const row = document.createElement('tr');
                addCell(row, employee.id);
                addCell(row, employee.full_name);
                addCell(row, employee.email);
                addCell(row, employee.position);
                addCell(row, employee.department?.name);

                const actionCell = document.createElement('td');
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.className = 'api-button api-button--danger api-button--small';
                deleteButton.textContent = 'Delete';
                deleteButton.addEventListener('click', async () => {
                    if (!window.confirm(`Delete ${employee.full_name}? This action cannot be undone.`)) {
                        return;
                    }

                    try {
                        await apiRequest(`/api/v1/employees/${employee.id}`, { method: 'DELETE' });
                        setStatus(apiStatus, `Employee #${employee.id} was deleted.`);
                        await loadEmployees();
                    } catch (error) {
                        setStatus(apiStatus, error.message, true);
                    }
                });
                actionCell.appendChild(deleteButton);
                row.appendChild(actionCell);
                employeeList.appendChild(row);
            }

            setStatus(apiStatus, `Loaded ${result.data.length} employee record(s).`);
        }

        document.getElementById('login-form').addEventListener('submit', async (event) => {
            event.preventDefault();
            const loginForm = event.currentTarget;
            const form = new FormData(loginForm);

            try {
                const result = await apiRequest('/api/v1/tokens', {
                    method: 'POST',
                    body: JSON.stringify({
                        email: form.get('email'),
                        password: form.get('password'),
                        device_name: form.get('device_name'),
                    }),
                    headers: {},
                });
                apiToken = result.token;
                loginForm.reset();
                employeeSection.hidden = false;
                document.getElementById('logout-button').hidden = false;
                setStatus(accountStatus, 'Connected successfully. You can now browse and manage employee records.');
                await loadEmployees();
            } catch (error) {
                apiToken = null;
                employeeSection.hidden = true;
                setStatus(accountStatus, error.message, true);
            }
        });

        document.getElementById('employee-form').addEventListener('submit', async (event) => {
            event.preventDefault();
            const employeeForm = event.currentTarget;
            const values = Object.fromEntries(new FormData(employeeForm));
            values.salary = Number(values.salary);
            values.department_id = Number(values.department_id);
            values.phone = values.phone || null;

            try {
                const result = await apiRequest('/api/v1/employees', {
                    method: 'POST',
                    body: JSON.stringify(values),
                });
                setStatus(apiStatus, `Employee #${result.data.id}, ${result.data.full_name}, was created successfully (HTTP 201).`);
                employeeForm.reset();
                await loadEmployees();
            } catch (error) {
                setStatus(apiStatus, error.message, true);
            }
        });

        document.getElementById('refresh-button').addEventListener('click', async () => {
            try {
                await loadEmployees();
            } catch (error) {
                setStatus(apiStatus, error.message, true);
            }
        });

        document.getElementById('logout-button').addEventListener('click', async () => {
            try {
                await apiRequest('/api/v1/tokens/current', { method: 'DELETE' });
                setStatus(accountStatus, 'Signed out. The API token has been revoked.');
            } catch (error) {
                setStatus(accountStatus, error.message, true);
            } finally {
                apiToken = null;
                employeeSection.hidden = true;
                document.getElementById('logout-button').hidden = true;
                employeeList.replaceChildren();
            }
        });
    </script>
</x-layout>
