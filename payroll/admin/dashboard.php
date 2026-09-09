<?php
session_start();
require_once 'connect.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

/* =========================================================
   USER
========================================================= */
$userName = 'Admin';
$uid = intval($_SESSION['user_id'] ?? 0);

if ($uid) {
    $s = $connection->prepare('SELECT username FROM users WHERE id = ? LIMIT 1');
    $s->bind_param('i', $uid);
    $s->execute();
    $r = $s->get_result();

    if ($r && $row = $r->fetch_assoc()) {
        $userName = $row['username'];
    }

    $s->close();
}

/* =========================================================
   COUNTS
========================================================= */
$deptCount = 0;
$posCount = 0;

$res = $connection->query('SELECT COUNT(*) AS c FROM departments');
if ($res) {
    $d = $res->fetch_assoc();
    $deptCount = intval($d['c']);
}

$res = $connection->query('SELECT COUNT(*) AS c FROM positions');
if ($res) {
    $p = $res->fetch_assoc();
    $posCount = intval($p['c']);
}

/* =========================================================
   DEPARTMENTS
========================================================= */
$depts = [];

$res = $connection->query(
    'SELECT id, name FROM departments ORDER BY id DESC'
);

if ($res) {
    while ($r = $res->fetch_assoc()) {
        $depts[] = $r;
    }
}

/* =========================================================
   POSITIONS
========================================================= */
$positions = [];

$res = $connection->query(
    'SELECT p.id, p.name FROM positions p ORDER BY p.id DESC'
);

if ($res) {
    while ($r = $res->fetch_assoc()) {
        $positions[] = $r;
    }
}

/* =========================================================
   EMPLOYEES
========================================================= */
$employees = [];

$res = $connection->query('
    SELECT
        e.*,

        (
            SELECT d.name
            FROM employee_positions ep
            LEFT JOIN departments d
                ON ep.department_id = d.id
            WHERE ep.employee_id = e.id
            ORDER BY ep.id DESC
            LIMIT 1
        ) AS department_name,

        (
            SELECT ep.department_id
            FROM employee_positions ep
            WHERE ep.employee_id = e.id
            ORDER BY ep.id DESC
            LIMIT 1
        ) AS department_id,

        (
            SELECT ep.position_id
            FROM employee_positions ep
            WHERE ep.employee_id = e.id
            ORDER BY ep.id DESC
            LIMIT 1
        ) AS employee_position_id,

        (
            SELECT ep.date_start
            FROM employee_positions ep
            WHERE ep.employee_id = e.id
            ORDER BY ep.id DESC
            LIMIT 1
        ) AS date_start,

        (
            SELECT ep.date_end
            FROM employee_positions ep
            WHERE ep.employee_id = e.id
            ORDER BY ep.id DESC
            LIMIT 1
        ) AS date_end,

        (
            SELECT ep.monthly_salary
            FROM employee_positions ep
            WHERE ep.employee_id = e.id
            ORDER BY ep.id DESC
            LIMIT 1
        ) AS monthly_salary,

        (
            SELECT ep.daily_salary
            FROM employee_positions ep
            WHERE ep.employee_id = e.id
            ORDER BY ep.id DESC
            LIMIT 1
        ) AS daily_salary,

        (
            SELECT ep.hourly_salary
            FROM employee_positions ep
            WHERE ep.employee_id = e.id
            ORDER BY ep.id DESC
            LIMIT 1
        ) AS hourly_salary,

        (
            SELECT ec.name
            FROM emergency_contacts ec
            WHERE ec.employee_id = e.id
            ORDER BY ec.id DESC
            LIMIT 1
        ) AS emergency_name,

        (
            SELECT ec.relationship
            FROM emergency_contacts ec
            WHERE ec.employee_id = e.id
            ORDER BY ec.id DESC
            LIMIT 1
        ) AS emergency_relationship,

        (
            SELECT ec.address
            FROM emergency_contacts ec
            WHERE ec.employee_id = e.id
            ORDER BY ec.id DESC
            LIMIT 1
        ) AS emergency_address,

        (
            SELECT ec.contact_no
            FROM emergency_contacts ec
            WHERE ec.employee_id = e.id
            ORDER BY ec.id DESC
            LIMIT 1
        ) AS emergency_contact_no,

        (
            SELECT d.name
            FROM dependents d
            WHERE d.employee_id = e.id
            ORDER BY d.id DESC
            LIMIT 1
        ) AS dependent_name,

        (
            SELECT d.birthdate
            FROM dependents d
            WHERE d.employee_id = e.id
            ORDER BY d.id DESC
            LIMIT 1
        ) AS dependent_birthdate,

        (
            SELECT d.relationship
            FROM dependents d
            WHERE d.employee_id = e.id
            ORDER BY d.id DESC
            LIMIT 1
        ) AS dependent_relationship,

        (
            SELECT eb.school
            FROM educational_backgrounds eb
            WHERE eb.employee_id = e.id
            ORDER BY eb.id DESC
            LIMIT 1
        ) AS school,

        (
            SELECT eb.address
            FROM educational_backgrounds eb
            WHERE eb.employee_id = e.id
            ORDER BY eb.id DESC
            LIMIT 1
        ) AS school_address,

        (
            SELECT eb.school_year
            FROM educational_backgrounds eb
            WHERE eb.employee_id = e.id
            ORDER BY eb.id DESC
            LIMIT 1
        ) AS school_year,

        (
            SELECT eb.level
            FROM educational_backgrounds eb
            WHERE eb.employee_id = e.id
            ORDER BY eb.id DESC
            LIMIT 1
        ) AS education_level,

        (
            SELECT cr.name
            FROM character_references cr
            WHERE cr.employee_id = e.id
            ORDER BY cr.id DESC
            LIMIT 1
        ) AS reference_name,

        (
            SELECT cr.occupation
            FROM character_references cr
            WHERE cr.employee_id = e.id
            ORDER BY cr.id DESC
            LIMIT 1
        ) AS reference_occupation,

        (
            SELECT cr.address
            FROM character_references cr
            WHERE cr.employee_id = e.id
            ORDER BY cr.id DESC
            LIMIT 1
        ) AS reference_address,

        (
            SELECT p.name
            FROM employee_positions ep
            LEFT JOIN positions p
                ON ep.position_id = p.id
            WHERE ep.employee_id = e.id
            ORDER BY ep.id DESC
            LIMIT 1
        ) AS position

    FROM employees e

    ORDER BY e.id DESC
');

if ($res) {
    while ($r = $res->fetch_assoc()) {
        $employees[] = $r;
    }
}
?>

<!doctype html>
<html lang="en">

<head>

<meta charset="utf-8">

<meta
    name="viewport"
    content="width=device-width,initial-scale=1"
>

<title>Payroll Admin — Dashboard</title>

<?php
$cssV = file_exists(__DIR__ . '/assets/css/styles.css')
    ? filemtime(__DIR__ . '/assets/css/styles.css')
    : time();
?>

<link
    rel="stylesheet"
    href="assets/css/styles.css?v=<?=$cssV?>"
>

<?php include 'includes/styles.php'; ?>

</head>

<body class="page-dashboard">

<?php include 'includes/navbar.php'; ?>

<!-- =========================================================
     MAIN
========================================================= -->

<main class="container">

<?php include 'includes/flash-messages.php'; ?>

<?php include 'includes/section-dashboard.php'; ?>

<?php include 'includes/section-departments-positions.php'; ?>

<?php include 'includes/section-employees.php'; ?>

</main>

<?php include 'includes/scripts.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const employeeForm = document.getElementById('employee-form');
    const employeeAction = document.getElementById('employee-form-action');
    const employeeEditId = document.getElementById('employee-edit-id');
    const employeeSubmit = document.getElementById('employee-submit');
    const empFormPanel = document.getElementById('emp-form');
    const addEmployeeButton = document.getElementById('add-employee-button') || document.querySelector('.btn-add[data-target="emp-form"]');
    const cancelEmployeeButton = document.getElementById('cancel-employee') || document.querySelector('#emp-form [data-action="cancel"]');
    const employeesSubnav = document.getElementById('employees-subnav');
    const employeeTabs = document.querySelectorAll('.employee-tab');
    const employeeContents = document.querySelectorAll('.employee-tab-content');

    // Search and Filter Elements
    const searchInput = document.getElementById('employee-search');
    const departmentFilter = document.getElementById('department-filter');
    const employeeTableBody = document.querySelector('#employees .table-responsive tbody');

    function filterEmployees() {
        if (!employeeTableBody) return;
        
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedDept = departmentFilter ? departmentFilter.value.toLowerCase().trim() : '';
        const rows = employeeTableBody.querySelectorAll('tr');

        rows.forEach(function (row) {
            const empNo = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
            const fullName = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
            const deptText = row.cells[3] ? row.cells[3].textContent.toLowerCase() : '';

            const matchesSearch = fullName.includes(searchTerm) || empNo.includes(searchTerm);
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

    function setValue(name, value) {
        if (!employeeForm) return;
        const field = employeeForm.querySelector('[name="' + name + '"]');
        if (field) field.value = value ?? '';
    }

    function showEmployeeForm() {
        if (empFormPanel) {
            empFormPanel.classList.remove('hidden');
            empFormPanel.style.display = 'block';
        }
        if (employeesSubnav) {
            employeesSubnav.style.display = 'flex';
        }
    }

    function hideEmployeeForm() {
        if (empFormPanel) {
            empFormPanel.classList.add('hidden');
            empFormPanel.style.display = 'none';
        }
        if (employeesSubnav) {
            employeesSubnav.style.display = 'none';
        }
    }

    function showEmployeeTab(tabId) {
        employeeTabs.forEach(function (tab) {
            tab.classList.toggle('active', tab.getAttribute('data-employee-tab') === tabId);
        });

        employeeContents.forEach(function (content) {
            const isTarget = content.id === tabId;
            content.classList.toggle('hidden', !isTarget);
            content.style.display = isTarget ? '' : 'none';
        });
    }

    // Employee tabs
    employeeTabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            showEmployeeTab(this.getAttribute('data-employee-tab'));
        });
    });

    // Add Employee
    if (addEmployeeButton) {
        addEmployeeButton.addEventListener('click', function () {
            if (employeeForm) employeeForm.reset();
            if (employeeAction) employeeAction.value = 'add_employee';
            if (employeeEditId) employeeEditId.value = '';

            setValue('nationality', 'Filipino');
            showEmployeeForm();
            showEmployeeTab('personal-info');

            if (employeeSubmit) employeeSubmit.textContent = 'Save Employee';
            if (addEmployeeButton) addEmployeeButton.textContent = '+ Add Employee';

            const password = document.querySelector('[name="portal_password"]');
            if (password) {
                password.required = true;
                password.placeholder = 'Set portal password';
            }

            setTimeout(function () {
                if (empFormPanel) empFormPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 50);
        });
    }

    // Edit Employee
    document.querySelectorAll('.edit-employee').forEach(function (button) {
        button.addEventListener('click', function () {
            if (!employeeForm) return;

            const d = this.dataset;
            showEmployeeForm();
            showEmployeeTab('personal-info');

            if (employeeAction) employeeAction.value = 'update_employee';
            if (employeeEditId) employeeEditId.value = d.id || '';

            setValue('employee_no', d.employeeNo);
            setValue('first_name', d.firstName);
            setValue('middle_name', d.middleName);
            setValue('last_name', d.lastName);
            setValue('gender', d.gender);
            setValue('email', d.email);
            setValue('phone', d.phone);
            setValue('civil_status', d.civilStatus);
            setValue('nationality', d.nationality || 'Filipino');
            setValue('religion', d.religion);
            setValue('birthdate', d.birthdate);
            setValue('present_address', d.presentAddress);
            setValue('permanent_address', d.permanentAddress);
            setValue('sss_no', d.sssNo);
            setValue('philhealth_no', d.philhealthNo);
            setValue('pagibig_no', d.pagibigNo);
            setValue('atm_no', d.atmNo);
            setValue('tin_no', d.tinNo);

            setValue('department_id', d.departmentId);
            setValue('position_id', d.positionId);
            setValue('date_start', d.dateStart);
            setValue('date_end', d.dateEnd);
            setValue('monthly_salary', d.monthlySalary);
            setValue('daily_salary', d.dailySalary);
            setValue('hourly_salary', d.hourlySalary);

            setValue('emergency_name', d.emergencyName);
            setValue('emergency_relationship', d.emergencyRelationship);
            setValue('emergency_address', d.emergencyAddress);
            setValue('emergency_contact_no', d.emergencyContactNo);

            setValue('dependent_name', d.dependentName);
            setValue('dependent_birthdate', d.dependentBirthdate);
            setValue('dependent_relationship', d.dependentRelationship);

            setValue('school', d.school);
            setValue('school_address', d.schoolAddress);
            setValue('school_year', d.schoolYear);
            setValue('education_level', d.educationLevel);

            setValue('reference_name', d.referenceName);
            setValue('reference_occupation', d.referenceOccupation);
            setValue('reference_address', d.referenceAddress);
            setValue('reference_contact', d.referenceContact);

            const password = document.querySelector('[name="portal_password"]');
            if (password) {
                password.required = false;
                password.value = '';
                password.placeholder = 'Leave blank to keep existing password when editing';
            }

            if (employeeSubmit) employeeSubmit.textContent = 'Update Employee';
            if (addEmployeeButton) addEmployeeButton.textContent = 'Edit Employee';

            setTimeout(function () {
                if (empFormPanel) empFormPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 50);
        });
    });

    // Cancel Employee
    if (cancelEmployeeButton) {
        cancelEmployeeButton.addEventListener('click', function () {
            if (employeeForm) employeeForm.reset();
            if (employeeAction) employeeAction.value = 'add_employee';
            if (employeeEditId) employeeEditId.value = '';
            setValue('nationality', 'Filipino');

            if (employeeSubmit) employeeSubmit.textContent = 'Save Employee';
            if (addEmployeeButton) addEmployeeButton.textContent = '+ Add Employee';

            hideEmployeeForm();
            showEmployeeTab('personal-info');
        });
    }

    // Form is hidden until Add/Edit is clicked.
    hideEmployeeForm();
    showEmployeeTab('personal-info');
});
</script>

</body>
</html>