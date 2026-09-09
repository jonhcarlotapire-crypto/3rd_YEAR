<style>

#employees {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    font-family: inherit;
    color: #0f172a;
}

/* Header Layout */
.employees-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 16px;
}

.employees-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #0f172a;
    margin: 0;
}

.controls-wrapper {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
    flex-grow: 1;
    justify-content: flex-end;
}

/* Form Inputs & Controls */
.form-control, 
.employees-header input[type="text"],
.employees-header select {
    width: 100%;
    padding: 8px 12px;
    font-size: 0.875rem;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    background-color: #fff;
    color: #0f172a;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.form-control:focus,
.employees-header input[type="text"]:focus,
.employees-header select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

/* Sub Navigation Tabs */
.employees-subnav {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    padding-bottom: 8px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
    scrollbar-width: thin;
}

.employees-subnav .employee-tab {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid transparent;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.875rem;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.2s;
}

.employees-subnav .employee-tab:hover {
    background: #e2e8f0;
    color: #1e293b;
}

.employees-subnav .employee-tab.active {
    background: #3b82f6;
    color: #ffffff;
    border-color: #3b82f6;
}

/* Form Grid System */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
    margin-top: 16px;
}

.form-grid.full-width {
    grid-template-columns: 1fr;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-group label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #334155;
}

.form-section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin: 24px 0 12px 0;
    padding-bottom: 6px;
    border-bottom: 1px solid #f1f5f9;
}

.form-section-title:first-of-type {
    margin-top: 0;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 6px;
    border: 1px solid transparent;
    cursor: pointer;
    transition: background-color 0.15s, border-color 0.15s;
    text-decoration: none;
}

.btn.primary {
    background-color: #3b82f6;
    color: #ffffff;
}

.btn.primary:hover {
    background-color: #2563eb;
}

.btn.danger {
    background-color: #ef4444;
    color: #ffffff;
}

.btn.danger:hover {
    background-color: #dc2626;
}

.btn.small {
    padding: 6px 12px;
    font-size: 0.8125rem;
}

/* Form Actions Bar */
.form-actions {
    margin-top: 24px;
    padding-top: 16px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    gap: 12px;
}

/* Responsive Table Wrapper */
.table-container {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow-x: auto;
    margin-top: 24px;
}

.table-container h4 {
    padding: 16px;
    margin: 0;
    font-size: 1rem;
    border-bottom: 1px solid #e2e8f0;
    background-color: #f8fafc;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    white-space: nowrap;
    text-align: left;
    font-size: 0.875rem;
}

.data-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 600;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.data-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background-color: #f8fafc;
}

/* Media Query for Mobile Responsiveness */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .controls-wrapper {
        justify-content: stretch;
    }
    
    .controls-wrapper input,
    .controls-wrapper select {
        max-width: none;
    }
}
</style>

<section id="employees" class="card large hidden">

    <!-- HEADER -->
    <div class="employees-header">
        <h3>Employees Directory</h3>

        <!-- SEARCH AND FILTER CONTROLS -->
        <div class="controls-wrapper">
            <input
                type="text"
                id="employee-search"
                placeholder="Search employee..."
            >

            <select id="department-filter">
                <option value="">All Departments</option>
                <?php foreach ($depts as $dept): ?>
                    <option value="<?=htmlspecialchars($dept['name'])?>">
                        <?=htmlspecialchars($dept['name'])?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="button" id="add-employee-button" class="btn primary">
            + Add Employee
        </button>
    </div>


    <!-- =====================================================
         EMPLOYEE SUB NAVBAR
    ====================================================== -->
    <div id="employees-subnav" class="employees-subnav">
        <button type="button" class="btn small employee-tab active" data-employee-tab="personal-info">
            Personal Info
        </button>

        <button type="button" class="btn small employee-tab" data-employee-tab="emergency-contact">
            Emergency Contact
        </button>

        <button type="button" class="btn small employee-tab" data-employee-tab="dependent">
            Dependent
        </button>

        <button type="button" class="btn small employee-tab" data-employee-tab="educational-background">
            Education
        </button>

        <button type="button" class="btn small employee-tab" data-employee-tab="character-reference">
            Reference
        </button>

        <button type="button" class="btn small employee-tab" data-employee-tab="employee-position">
            Position & Salary
        </button>
    </div>


    <!-- =====================================================
         EMPLOYEE FORM
    ====================================================== -->
    <div id="emp-form" class="form-panel">
        <form
            id="employee-form"
            method="post"
            action="actions.php"
            enctype="multipart/form-data"
        >
            <input
                type="hidden"
                name="action"
                id="employee-form-action"
                value="add_employee"
            >

            <input
                type="hidden"
                name="id"
                id="employee-edit-id"
                value=""
            >


            <!-- =================================================
                 TAB 1 PERSONAL
            ================================================== -->
            <div
                id="personal-info"
                class="employee-tab-content show"
            >
                <h4 class="form-section-title">Account & Basic Details</h4>

                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Profile Picture
                            <input
                                type="file"
                                name="profile_picture"
                                accept="image/*"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Employee No.
                            <input
                                name="employee_no"
                                required
                                placeholder="EMP-2026-001"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid full-width">
                    <div class="form-group">
                        <label>
                            Portal Password
                            <input
                                type="password"
                                name="portal_password"
                                placeholder="Leave blank to keep existing password when editing"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            First Name
                            <input
                                name="first_name"
                                required
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Middle Name
                            <input
                                name="middle_name"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Last Name
                            <input
                                name="last_name"
                                required
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Gender
                            <select name="gender" class="form-control">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </label>
                    </div>
                </div>


                <h4 class="form-section-title">Personal Information</h4>

                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Email
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Contact No.
                            <input
                                name="phone"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Civil Status
                            <select name="civil_status" class="form-control">
                                <option value="">Select</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Separated">Separated</option>
                            </select>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Nationality
                            <input
                                name="nationality"
                                value="Filipino"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Religion
                            <input
                                name="religion"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Birthdate
                            <input
                                type="date"
                                name="birthdate"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Present Address
                            <textarea
                                name="present_address"
                                rows="2"
                                class="form-control"
                            ></textarea>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Permanent Address
                            <textarea
                                name="permanent_address"
                                rows="2"
                                class="form-control"
                            ></textarea>
                        </label>
                    </div>
                </div>


                <h4 class="form-section-title">Government IDs</h4>

                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            SSS No.
                            <input
                                name="sss_no"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            PhilHealth No.
                            <input
                                name="philhealth_no"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Pag-IBIG No.
                            <input
                                name="pagibig_no"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            ATM No.
                            <input
                                name="atm_no"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid full-width">
                    <div class="form-group">
                        <label>
                            TIN
                            <input
                                name="tin_no"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>

            </div>


            <!-- =================================================
                 TAB 2 EMERGENCY
            ================================================== -->
            <div
                id="emergency-contact"
                class="employee-tab-content"
            >
                <h4 class="form-section-title">Emergency Contact</h4>

                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Name
                            <input
                                type="text"
                                name="emergency_name"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Relationship
                            <input
                                type="text"
                                name="emergency_relationship"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Address
                            <textarea
                                name="emergency_address"
                                rows="2"
                                class="form-control"
                            ></textarea>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Contact No.
                            <input
                                type="text"
                                name="emergency_contact_no"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>

            </div>


            <!-- =================================================
                 TAB 3 DEPENDENT
            ================================================== -->
            <div
                id="dependent"
                class="employee-tab-content"
            >
                <h4 class="form-section-title">Dependent Information</h4>

                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Name
                            <input
                                type="text"
                                name="dependent_name"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Birthdate
                            <input
                                type="date"
                                name="dependent_birthdate"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid full-width">
                    <div class="form-group">
                        <label>
                            Relationship
                            <input
                                type="text"
                                name="dependent_relationship"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>

            </div>


            <!-- =================================================
                 TAB 4 EDUCATION
            ================================================== -->
            <div
                id="educational-background"
                class="employee-tab-content"
            >
                <h4 class="form-section-title">Educational Background</h4>

                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            School
                            <input
                                type="text"
                                name="school"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Address
                            <textarea
                                name="school_address"
                                rows="2"
                                class="form-control"
                            ></textarea>
                        </label>
                    </div>
                </div>


                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            School Year
                            <input
                                type="text"
                                name="school_year"
                                placeholder="2025-2026"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Level
                            <select name="education_level" class="form-control">
                                <option value="">Select Level</option>
                                <option value="Primary">Primary</option>
                                <option value="Secondary">Secondary</option>
                                <option value="Tertiary">Tertiary</option>
                                <option value="Post-Graduate">Post-Graduate</option>
                            </select>
                        </label>
                    </div>
                </div>

            </div>


            <!-- =================================================
                 TAB 5 REFERENCE
            ================================================== -->
            <div
                id="character-reference"
                class="employee-tab-content"
            >
                <h4 class="form-section-title">Character Reference</h4>

                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Name
                            <input
                                type="text"
                                name="reference_name"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Occupation
                            <input
                                type="text"
                                name="reference_occupation"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Address
                            <textarea
                                name="reference_address"
                                rows="2"
                                class="form-control"
                            ></textarea>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Contact
                            <input
                                type="text"
                                name="reference_contact"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>

            </div>


            <!-- =================================================
                 TAB 6 POSITION
            ================================================== -->
            <div
                id="employee-position"
                class="employee-tab-content"
            >
                <h4 class="form-section-title">Employee Position & Salary</h4>

                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Department
                            <select name="department_id" class="form-control">
                                <option value="">Select Department</option>
                                <?php foreach ($depts as $dept): ?>
                                    <option value="<?=$dept['id']?>">
                                        <?=htmlspecialchars($dept['name'])?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Position
                            <select name="position_id" class="form-control">
                                <option value="">Select Position</option>
                                <?php foreach ($positions as $pos): ?>
                                    <option value="<?=$pos['id']?>">
                                        <?=htmlspecialchars($pos['name'])?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                </div>


                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Date Start
                            <input
                                type="date"
                                name="date_start"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Date End
                            <input
                                type="date"
                                name="date_end"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <h4 class="form-section-title">Salary Rates</h4>

                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            Monthly
                            <input
                                type="number"
                                step="0.01"
                                name="monthly_salary"
                                class="form-control"
                            >
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Daily
                            <input
                                type="number"
                                step="0.01"
                                name="daily_salary"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>


                <div class="form-grid full-width">
                    <div class="form-group">
                        <label>
                            Hourly
                            <input
                                type="number"
                                step="0.01"
                                name="hourly_salary"
                                class="form-control"
                            >
                        </label>
                    </div>
                </div>

            </div>


            <!-- =================================================
                 FORM BUTTONS
            ================================================== -->
            <div class="form-actions">
                <button
                    class="btn primary"
                    id="employee-submit"
                    type="submit"
                >
                    Save Employee
                </button>

                <button
                    type="button"
                    class="btn small"
                    id="cancel-employee"
                >
                    Cancel
                </button>
            </div>

        </form>
    </div>


    <!-- =====================================================
         EMPLOYEE TABLE
    ====================================================== -->
    <div class="table-container">
        <h4>Employees List (All Information)</h4>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Emp No.</th>
                    <th>Full Name</th>
                    <th>Department & Position</th>
                    <th>Contact Details</th>
                    <th>Personal Info</th>
                    <th>Addresses</th>
                    <th>Government IDs</th>
                    <th>Employment Dates</th>
                    <th>Salary Rates</th>
                    <th>Emergency Contact</th>
                    <th>Dependent</th>
                    <th>Education</th>
                    <th>Reference</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($employees as $emp): ?>
                <tr>
                    <!-- PHOTO -->
                    <td>
                        <?php $photo = $emp['profile_picture'] ?? ''; ?>
                        <?php if (!empty($photo) && file_exists($photo)): ?>
                            <img
                                src="<?=htmlspecialchars($photo)?>"
                                alt="Profile"
                                style="width:36px; height:36px; border-radius:50%; object-fit:cover;"
                            >
                        <?php else: ?>
                            <div style="width:36px; height:36px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; font-weight:bold; color:#64748b;">
                                <?=htmlspecialchars(strtoupper(substr($emp['first_name'] ?? '?', 0, 1)))?>
                            </div>
                        <?php endif; ?>
                    </td>

                    <td>
                        <strong><?=htmlspecialchars($emp['employee_no'] ?? '—')?></strong>
                    </td>

                    <td>
                        <?=htmlspecialchars(($emp['last_name'] ?? '') . ', ' . ($emp['first_name'] ?? '') . ' ' . ($emp['middle_name'] ?? ''))?>
                    </td>

                    <td>
                        <div>
                            <strong><?=htmlspecialchars($emp['department_name'] ?? '—')?></strong>
                        </div>
                        <div class="small muted" style="color: #64748b; font-size: 0.75rem;">
                            <?=htmlspecialchars($emp['position'] ?? '—')?>
                        </div>
                    </td>

                    <td class="small">
                        <div>Email: <?=htmlspecialchars($emp['email'] ?? '—')?></div>
                        <div>Phone: <?=htmlspecialchars($emp['phone'] ?? '—')?></div>
                    </td>

                    <td class="small">
                        <div>
                            Gender: <?=htmlspecialchars($emp['gender'] ?? '—')?> | Civil: <?=htmlspecialchars($emp['civil_status'] ?? '—')?>
                        </div>
                        <div>
                            Nat: <?=htmlspecialchars($emp['nationality'] ?? '—')?> | Rel: <?=htmlspecialchars($emp['religion'] ?? '—')?>
                        </div>
                        <div>
                            Birthdate: <?=htmlspecialchars($emp['birthdate'] ?? '—')?>
                        </div>
                    </td>

                    <td class="small">
                        <div>Present: <?=htmlspecialchars($emp['present_address'] ?? '—')?></div>
                        <div>Permanent: <?=htmlspecialchars($emp['permanent_address'] ?? '—')?></div>
                    </td>

                    <td class="small">
                        <div>SSS: <?=htmlspecialchars($emp['sss_no'] ?? '—')?></div>
                        <div>PhilHealth: <?=htmlspecialchars($emp['philhealth_no'] ?? '—')?></div>
                        <div>Pag-IBIG: <?=htmlspecialchars($emp['pagibig_no'] ?? '—')?></div>
                        <div>ATM: <?=htmlspecialchars($emp['atm_no'] ?? '—')?> | TIN: <?=htmlspecialchars($emp['tin_no'] ?? '—')?></div>
                    </td>

                    <td class="small">
                        <div>Start: <?=htmlspecialchars($emp['date_start'] ?? '—')?></div>
                        <div>End: <?=htmlspecialchars($emp['date_end'] ?? '—')?></div>
                    </td>

                    <td class="small">
                        <div>
                            Monthly: <?=($emp['monthly_salary'] !== null) ? number_format($emp['monthly_salary'], 2) : '—'?>
                        </div>
                        <div>
                            Daily: <?=($emp['daily_salary'] !== null) ? number_format($emp['daily_salary'], 2) : '—'?>
                        </div>
                        <div>
                            Hourly: <?=($emp['hourly_salary'] !== null) ? number_format($emp['hourly_salary'], 2) : '—'?>
                        </div>
                    </td>

                    <td class="small">
                        <div>
                            Name: <?=htmlspecialchars($emp['emergency_name'] ?? '—')?> (<?=htmlspecialchars($emp['emergency_relationship'] ?? '—')?>)
                        </div>
                        <div>Contact: <?=htmlspecialchars($emp['emergency_contact_no'] ?? '—')?></div>
                        <div>Address: <?=htmlspecialchars($emp['emergency_address'] ?? '—')?></div>
                    </td>

                    <td class="small">
                        <div>
                            Name: <?=htmlspecialchars($emp['dependent_name'] ?? '—')?> (<?=htmlspecialchars($emp['dependent_relationship'] ?? '—')?>)
                        </div>
                        <div>Birth: <?=htmlspecialchars($emp['dependent_birthdate'] ?? '—')?></div>
                    </td>

                    <td class="small">
                        <div>
                            School: <?=htmlspecialchars($emp['school'] ?? '—')?> (<?=htmlspecialchars($emp['education_level'] ?? '—')?>)
                        </div>
                        <div>Year: <?=htmlspecialchars($emp['school_year'] ?? '—')?></div>
                        <div>Address: <?=htmlspecialchars($emp['school_address'] ?? '—')?></div>
                    </td>

                    <td class="small">
                        <div>
                            Name: <?=htmlspecialchars($emp['reference_name'] ?? '—')?> (<?=htmlspecialchars($emp['reference_occupation'] ?? '—')?>)
                        </div>
                        <div>Contact: <?=htmlspecialchars($emp['reference_contact'] ?? '—')?></div>
                        <div>Address: <?=htmlspecialchars($emp['reference_address'] ?? '—')?></div>
                    </td>

                    <!-- ACTIONS -->
                    <td class="text-right">
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <button
                                type="button"
                                class="btn small edit-employee"
                                data-id="<?=intval($emp['id'])?>"
                                data-employee-no="<?=htmlspecialchars($emp['employee_no'] ?? '', ENT_QUOTES)?>"
                                data-first-name="<?=htmlspecialchars($emp['first_name'] ?? '', ENT_QUOTES)?>"
                                data-middle-name="<?=htmlspecialchars($emp['middle_name'] ?? '', ENT_QUOTES)?>"
                                data-last-name="<?=htmlspecialchars($emp['last_name'] ?? '', ENT_QUOTES)?>"
                                data-gender="<?=htmlspecialchars($emp['gender'] ?? '', ENT_QUOTES)?>"
                                data-email="<?=htmlspecialchars($emp['email'] ?? '', ENT_QUOTES)?>"
                                data-phone="<?=htmlspecialchars($emp['phone'] ?? '', ENT_QUOTES)?>"
                                data-civil-status="<?=htmlspecialchars($emp['civil_status'] ?? '', ENT_QUOTES)?>"
                                data-nationality="<?=htmlspecialchars($emp['nationality'] ?? 'Filipino', ENT_QUOTES)?>"
                                data-religion="<?=htmlspecialchars($emp['religion'] ?? '', ENT_QUOTES)?>"
                                data-birthdate="<?=htmlspecialchars($emp['birthdate'] ?? '', ENT_QUOTES)?>"
                                data-present-address="<?=htmlspecialchars($emp['present_address'] ?? '', ENT_QUOTES)?>"
                                data-permanent-address="<?=htmlspecialchars($emp['permanent_address'] ?? '', ENT_QUOTES)?>"
                                data-sss-no="<?=htmlspecialchars($emp['sss_no'] ?? '', ENT_QUOTES)?>"
                                data-philhealth-no="<?=htmlspecialchars($emp['philhealth_no'] ?? '', ENT_QUOTES)?>"
                                data-pagibig-no="<?=htmlspecialchars($emp['pagibig_no'] ?? '', ENT_QUOTES)?>"
                                data-atm-no="<?=htmlspecialchars($emp['atm_no'] ?? '', ENT_QUOTES)?>"
                                data-tin-no="<?=htmlspecialchars($emp['tin_no'] ?? '', ENT_QUOTES)?>"
                                data-department-id="<?=intval($emp['department_id'] ?? 0)?>"
                                data-position-id="<?=intval($emp['employee_position_id'] ?? $emp['position_id'] ?? 0)?>"
                                data-date-start="<?=htmlspecialchars($emp['date_start'] ?? '', ENT_QUOTES)?>"
                                data-date-end="<?=htmlspecialchars($emp['date_end'] ?? '', ENT_QUOTES)?>"
                                data-monthly-salary="<?=htmlspecialchars($emp['monthly_salary'] ?? '', ENT_QUOTES)?>"
                                data-daily-salary="<?=htmlspecialchars($emp['daily_salary'] ?? '', ENT_QUOTES)?>"
                                data-hourly-salary="<?=htmlspecialchars($emp['hourly_salary'] ?? '', ENT_QUOTES)?>"
                                data-emergency-name="<?=htmlspecialchars($emp['emergency_name'] ?? '', ENT_QUOTES)?>"
                                data-emergency-relationship="<?=htmlspecialchars($emp['emergency_relationship'] ?? '', ENT_QUOTES)?>"
                                data-emergency-address="<?=htmlspecialchars($emp['emergency_address'] ?? '', ENT_QUOTES)?>"
                                data-emergency-contact-no="<?=htmlspecialchars($emp['emergency_contact_no'] ?? '', ENT_QUOTES)?>"
                                data-dependent-name="<?=htmlspecialchars($emp['dependent_name'] ?? '', ENT_QUOTES)?>"
                                data-dependent-birthdate="<?=htmlspecialchars($emp['dependent_birthdate'] ?? '', ENT_QUOTES)?>"
                                data-dependent-relationship="<?=htmlspecialchars($emp['dependent_relationship'] ?? '', ENT_QUOTES)?>"
                                data-school="<?=htmlspecialchars($emp['school'] ?? '', ENT_QUOTES)?>"
                                data-school-address="<?=htmlspecialchars($emp['school_address'] ?? '', ENT_QUOTES)?>"
                                data-school-year="<?=htmlspecialchars($emp['school_year'] ?? '', ENT_QUOTES)?>"
                                data-education-level="<?=htmlspecialchars($emp['education_level'] ?? '', ENT_QUOTES)?>"
                                data-reference-name="<?=htmlspecialchars($emp['reference_name'] ?? '', ENT_QUOTES)?>"
                                data-reference-occupation="<?=htmlspecialchars($emp['reference_occupation'] ?? '', ENT_QUOTES)?>"
                                data-reference-address="<?=htmlspecialchars($emp['reference_address'] ?? '', ENT_QUOTES)?>"
                                data-reference-contact="<?=htmlspecialchars($emp['reference_contact'] ?? '', ENT_QUOTES)?>"
                            >
                                Edit
                            </button>


                            <form
                                method="post"
                                action="actions.php"
                                class="inline-form"
                            >
                                <input
                                    type="hidden"
                                    name="action"
                                    value="delete_employee"
                                >

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?=$emp['id']?>"
                                >

                                <button
                                    type="submit"
                                    class="btn small danger"
                                    onclick="return confirm('Delete employee?')"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('employee-search');
    const departmentFilter = document.getElementById('department-filter');
    const tableRows = document.querySelectorAll('.data-table tbody tr');

    function filterEmployees() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedDept = departmentFilter.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const deptCell = row.cells[3];
            const deptText = deptCell ? deptCell.textContent.toLowerCase() : '';

            const matchesSearch = rowText.includes(searchTerm);
            const matchesDept = selectedDept === '' || deptText.includes(selectedDept);

            if (matchesSearch && matchesDept) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterEmployees);
    }

    if (departmentFilter) {
        departmentFilter.addEventListener('change', filterEmployees);
    }
});
</script>