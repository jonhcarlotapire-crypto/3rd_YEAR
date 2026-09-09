<?php
session_start();
require_once 'connect.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$action = $_POST['action'] ?? '';

function redirect_dashboard($hash = 'home')
{
    header('Location: dashboard.php#' . $hash);
    exit;
}

function flash_error($message, $tab = 'employees')
{
    $_SESSION['flash_error'] = $message;
    redirect_dashboard($tab);
}

function flash_success($message, $tab = 'employees')
{
    $_SESSION['flash_success'] = $message;
    redirect_dashboard($tab);
}

function post_string($name)
{
    return trim($_POST[$name] ?? '');
}

function post_int($name)
{
    $value = $_POST[$name] ?? '';
    return ($value === '' || $value === null) ? null : intval($value);
}

function post_decimal($name)
{
    $value = trim($_POST[$name] ?? '');
    return ($value === '' || $value === null) ? null : floatval($value);
}

function post_date($name)
{
    $value = trim($_POST[$name] ?? '');
    return $value === '' ? null : $value;
}

function upload_profile_picture()
{
    if (
        !isset($_FILES['profile_picture']) ||
        $_FILES['profile_picture']['error'] === UPLOAD_ERR_NO_FILE
    ) {
        return null;
    }

    if ($_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Profile picture upload failed.');
    }

    $tmp = $_FILES['profile_picture']['tmp_name'];
    $original = $_FILES['profile_picture']['name'];

    $info = @getimagesize($tmp);

    if (!$info) {
        throw new Exception('The uploaded profile picture is not a valid image.');
    }

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp'
    ];

    $mime = $info['mime'];

    if (!isset($allowed[$mime])) {
        throw new Exception('Only JPG, PNG, GIF, and WEBP images are allowed.');
    }

    $uploadDir = __DIR__ . '/uploads/employees';

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            throw new Exception('Unable to create employee upload directory.');
        }
    }

    $filename = 'employee_' . time() . '_' . bin2hex(random_bytes(5)) . '.' . $allowed[$mime];

    $destination = $uploadDir . '/' . $filename;

    if (!move_uploaded_file($tmp, $destination)) {
        throw new Exception('Unable to save profile picture.');
    }

    return 'uploads/employees/' . $filename;
}

try {

    if ($action === '') {
        redirect_dashboard('home');
    }


    /*
     * DEPARTMENT
     */

    if ($action === 'add_department') {

        $name = post_string('name');

        if ($name === '') {
            flash_error('Department name is required.', 'dept-pos');
        }

        $stmt = $connection->prepare(
            'INSERT INTO departments (name) VALUES (?)'
        );

        $stmt->bind_param('s', $name);
        $stmt->execute();

        flash_success('Department added successfully.', 'dept-pos');
    }


    if ($action === 'update_department') {

        $id = intval($_POST['id'] ?? 0);
        $name = post_string('name');

        if ($id <= 0 || $name === '') {
            flash_error('Invalid department information.', 'dept-pos');
        }

        $stmt = $connection->prepare(
            'UPDATE departments SET name = ? WHERE id = ?'
        );

        $stmt->bind_param('si', $name, $id);
        $stmt->execute();

        flash_success('Department updated successfully.', 'dept-pos');
    }


    if ($action === 'delete_department') {

        $id = intval($_POST['id'] ?? 0);

        if ($id <= 0) {
            flash_error('Invalid department.', 'dept-pos');
        }

        $stmt = $connection->prepare(
            'DELETE FROM departments WHERE id = ?'
        );

        $stmt->bind_param('i', $id);
        $stmt->execute();

        flash_success('Department deleted successfully.', 'dept-pos');
    }


    /*
     * POSITION
     */

    if ($action === 'add_position') {

        $name = post_string('name');

        if ($name === '') {
            flash_error('Position name is required.', 'dept-pos');
        }

        $stmt = $connection->prepare(
            'INSERT INTO positions (name) VALUES (?)'
        );

        $stmt->bind_param('s', $name);
        $stmt->execute();

        flash_success('Position added successfully.', 'dept-pos');
    }


    if ($action === 'update_position') {

        $id = intval($_POST['id'] ?? 0);
        $name = post_string('name');

        if ($id <= 0 || $name === '') {
            flash_error('Invalid position information.', 'dept-pos');
        }

        $stmt = $connection->prepare(
            'UPDATE positions SET name = ? WHERE id = ?'
        );

        $stmt->bind_param('si', $name, $id);
        $stmt->execute();

        flash_success('Position updated successfully.', 'dept-pos');
    }


    if ($action === 'delete_position') {

        $id = intval($_POST['id'] ?? 0);

        if ($id <= 0) {
            flash_error('Invalid position.', 'dept-pos');
        }

        $stmt = $connection->prepare(
            'DELETE FROM positions WHERE id = ?'
        );

        $stmt->bind_param('i', $id);
        $stmt->execute();

        flash_success('Position deleted successfully.', 'dept-pos');
    }


    /*
     * ADD EMPLOYEE
     */

    if ($action === 'add_employee') {

        $employeeNo = post_string('employee_no');
        $password = post_string('portal_password');

        $firstName = post_string('first_name');
        $middleName = post_string('middle_name');
        $lastName = post_string('last_name');

        $gender = post_string('gender');
        $email = post_string('email');
        $phone = post_string('phone');

        $civilStatus = post_string('civil_status');
        $nationality = post_string('nationality');
        $religion = post_string('religion');
        $birthdate = post_date('birthdate');

        $presentAddress = post_string('present_address');
        $permanentAddress = post_string('permanent_address');

        $sssNo = post_string('sss_no');
        $philhealthNo = post_string('philhealth_no');
        $pagibigNo = post_string('pagibig_no');
        $atmNo = post_string('atm_no');
        $tinNo = post_string('tin_no');

        if ($employeeNo === '') {
            flash_error('Employee number is required.');
        }

        if ($firstName === '' || $lastName === '') {
            flash_error('First name and last name are required.');
        }

        if ($password === '') {
            flash_error('Portal password is required when adding an employee.');
        }

        $check = $connection->prepare(
            'SELECT id FROM employees WHERE employee_no = ? LIMIT 1'
        );

        $check->bind_param('s', $employeeNo);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {
            flash_error('Employee number already exists.');
        }

        $profilePicture = upload_profile_picture();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $connection->begin_transaction();

        try {

            $stmt = $connection->prepare(
                'INSERT INTO employees (
                    employee_no,
                    portal_password,
                    profile_picture,
                    first_name,
                    middle_name,
                    last_name,
                    gender,
                    email,
                    phone,
                    civil_status,
                    nationality,
                    religion,
                    birthdate,
                    present_address,
                    permanent_address,
                    sss_no,
                    philhealth_no,
                    pagibig_no,
                    atm_no,
                    tin_no
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                )'
            );

            $stmt->bind_param(
                'ssssssssssssssssssss',
                $employeeNo,
                $hashedPassword,
                $profilePicture,
                $firstName,
                $middleName,
                $lastName,
                $gender,
                $email,
                $phone,
                $civilStatus,
                $nationality,
                $religion,
                $birthdate,
                $presentAddress,
                $permanentAddress,
                $sssNo,
                $philhealthNo,
                $pagibigNo,
                $atmNo,
                $tinNo
            );

            $stmt->execute();

            $employeeId = $connection->insert_id;


            /*
             * Employee Position
             */

            $departmentId = post_int('department_id');
            $positionId = post_int('position_id');

            $dateStart = post_date('date_start');
            $dateEnd = post_date('date_end');

            $monthlySalary = post_decimal('monthly_salary');
            $dailySalary = post_decimal('daily_salary');
            $hourlySalary = post_decimal('hourly_salary');

            if (
                $departmentId !== null ||
                $positionId !== null ||
                $dateStart !== null ||
                $dateEnd !== null ||
                $monthlySalary !== null ||
                $dailySalary !== null ||
                $hourlySalary !== null
            ) {

                $stmt = $connection->prepare(
                    'INSERT INTO employee_positions (
                        employee_id,
                        department_id,
                        position_id,
                        date_start,
                        date_end,
                        monthly_salary,
                        daily_salary,
                        hourly_salary
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
                );

                $stmt->bind_param(
                    'iiissddd',
                    $employeeId,
                    $departmentId,
                    $positionId,
                    $dateStart,
                    $dateEnd,
                    $monthlySalary,
                    $dailySalary,
                    $hourlySalary
                );

                $stmt->execute();
            }


            /*
             * Emergency Contact
             */

            $emergencyName = post_string('emergency_name');
            $emergencyRelationship = post_string('emergency_relationship');
            $emergencyAddress = post_string('emergency_address');
            $emergencyContactNo = post_string('emergency_contact_no');

            if (
                $emergencyName !== '' ||
                $emergencyRelationship !== '' ||
                $emergencyAddress !== '' ||
                $emergencyContactNo !== ''
            ) {

                $stmt = $connection->prepare(
                    'INSERT INTO emergency_contacts (
                        employee_id,
                        name,
                        relationship,
                        address,
                        contact_no
                    ) VALUES (?, ?, ?, ?, ?)'
                );

                $stmt->bind_param(
                    'issss',
                    $employeeId,
                    $emergencyName,
                    $emergencyRelationship,
                    $emergencyAddress,
                    $emergencyContactNo
                );

                $stmt->execute();
            }


            /*
             * Dependent
             */

            $dependentName = post_string('dependent_name');
            $dependentBirthdate = post_date('dependent_birthdate');
            $dependentRelationship = post_string('dependent_relationship');

            if (
                $dependentName !== '' ||
                $dependentBirthdate !== null ||
                $dependentRelationship !== ''
            ) {

                $stmt = $connection->prepare(
                    'INSERT INTO dependents (
                        employee_id,
                        name,
                        birthdate,
                        relationship
                    ) VALUES (?, ?, ?, ?)'
                );

                $stmt->bind_param(
                    'isss',
                    $employeeId,
                    $dependentName,
                    $dependentBirthdate,
                    $dependentRelationship
                );

                $stmt->execute();
            }


            /*
             * Education
             */

            $school = post_string('school');
            $schoolAddress = post_string('school_address');
            $schoolYear = post_string('school_year');
            $educationLevel = post_string('education_level');

            if (
                $school !== '' ||
                $schoolAddress !== '' ||
                $schoolYear !== '' ||
                $educationLevel !== ''
            ) {

                $stmt = $connection->prepare(
                    'INSERT INTO educational_backgrounds (
                        employee_id,
                        school,
                        address,
                        school_year,
                        level
                    ) VALUES (?, ?, ?, ?, ?)'
                );

                $stmt->bind_param(
                    'issss',
                    $employeeId,
                    $school,
                    $schoolAddress,
                    $schoolYear,
                    $educationLevel
                );

                $stmt->execute();
            }


            /*
             * Character Reference
             */

            $referenceName = post_string('reference_name');
            $referenceOccupation = post_string('reference_occupation');
            $referenceAddress = post_string('reference_address');
            $referenceContact = post_string('reference_contact');

            if (
                $referenceName !== '' ||
                $referenceOccupation !== '' ||
                $referenceAddress !== '' ||
                $referenceContact !== ''
            ) {

                $stmt = $connection->prepare(
                    'INSERT INTO character_references (
                        employee_id,
                        name,
                        occupation,
                        address,
                        contact
                    ) VALUES (?, ?, ?, ?, ?)'
                );

                $stmt->bind_param(
                    'issss',
                    $employeeId,
                    $referenceName,
                    $referenceOccupation,
                    $referenceAddress,
                    $referenceContact
                );

                $stmt->execute();
            }

            $connection->commit();

            flash_success('Employee added successfully.');

        } catch (Throwable $e) {

            $connection->rollback();

            if (!empty($profilePicture)) {
                $file = __DIR__ . '/' . $profilePicture;

                if (file_exists($file)) {
                    @unlink($file);
                }
            }

            throw $e;
        }
    }


    /*
     * UPDATE EMPLOYEE
     */

    if ($action === 'update_employee') {

        $employeeId = intval($_POST['id'] ?? 0);

        if ($employeeId <= 0) {
            flash_error('Invalid employee ID.');
        }

        $employeeNo = post_string('employee_no');

        $firstName = post_string('first_name');
        $middleName = post_string('middle_name');
        $lastName = post_string('last_name');

        $gender = post_string('gender');
        $email = post_string('email');
        $phone = post_string('phone');

        $civilStatus = post_string('civil_status');
        $nationality = post_string('nationality');
        $religion = post_string('religion');
        $birthdate = post_date('birthdate');

        $presentAddress = post_string('present_address');
        $permanentAddress = post_string('permanent_address');

        $sssNo = post_string('sss_no');
        $philhealthNo = post_string('philhealth_no');
        $pagibigNo = post_string('pagibig_no');
        $atmNo = post_string('atm_no');
        $tinNo = post_string('tin_no');

        if ($employeeNo === '') {
            flash_error('Employee number is required.');
        }

        if ($firstName === '' || $lastName === '') {
            flash_error('First name and last name are required.');
        }

        $check = $connection->prepare(
            'SELECT id FROM employees WHERE employee_no = ? AND id <> ? LIMIT 1'
        );

        $check->bind_param(
            'si',
            $employeeNo,
            $employeeId
        );

        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {
            flash_error('Employee number already belongs to another employee.');
        }

        $newProfilePicture = upload_profile_picture();

        $connection->begin_transaction();

        try {

            if ($newProfilePicture !== null) {

                $stmt = $connection->prepare(
                    'UPDATE employees SET
                        employee_no = ?,
                        profile_picture = ?,
                        first_name = ?,
                        middle_name = ?,
                        last_name = ?,
                        gender = ?,
                        email = ?,
                        phone = ?,
                        civil_status = ?,
                        nationality = ?,
                        religion = ?,
                        birthdate = ?,
                        present_address = ?,
                        permanent_address = ?,
                        sss_no = ?,
                        philhealth_no = ?,
                        pagibig_no = ?,
                        atm_no = ?,
                        tin_no = ?
                    WHERE id = ?'
                );

                $stmt->bind_param(
                    'sssssssssssssssssssi',
                    $employeeNo,
                    $newProfilePicture,
                    $firstName,
                    $middleName,
                    $lastName,
                    $gender,
                    $email,
                    $phone,
                    $civilStatus,
                    $nationality,
                    $religion,
                    $birthdate,
                    $presentAddress,
                    $permanentAddress,
                    $sssNo,
                    $philhealthNo,
                    $pagibigNo,
                    $atmNo,
                    $tinNo,
                    $employeeId
                );

                $stmt->execute();

            } else {

                $stmt = $connection->prepare(
                    'UPDATE employees SET
                        employee_no = ?,
                        first_name = ?,
                        middle_name = ?,
                        last_name = ?,
                        gender = ?,
                        email = ?,
                        phone = ?,
                        civil_status = ?,
                        nationality = ?,
                        religion = ?,
                        birthdate = ?,
                        present_address = ?,
                        permanent_address = ?,
                        sss_no = ?,
                        philhealth_no = ?,
                        pagibig_no = ?,
                        atm_no = ?,
                        tin_no = ?
                    WHERE id = ?'
                );

                $stmt->bind_param(
                    'ssssssssssssssssssi',
                    $employeeNo,
                    $firstName,
                    $middleName,
                    $lastName,
                    $gender,
                    $email,
                    $phone,
                    $civilStatus,
                    $nationality,
                    $religion,
                    $birthdate,
                    $presentAddress,
                    $permanentAddress,
                    $sssNo,
                    $philhealthNo,
                    $pagibigNo,
                    $atmNo,
                    $tinNo,
                    $employeeId
                );

                $stmt->execute();
            }


            $password = post_string('portal_password');

            if ($password !== '') {

                $hashedPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $stmt = $connection->prepare(
                    'UPDATE employees
                     SET portal_password = ?
                     WHERE id = ?'
                );

                $stmt->bind_param(
                    'si',
                    $hashedPassword,
                    $employeeId
                );

                $stmt->execute();
            }


            /*
             * Employee Position
             */

            $departmentId = post_int('department_id');
            $positionId = post_int('position_id');

            $dateStart = post_date('date_start');
            $dateEnd = post_date('date_end');

            $monthlySalary = post_decimal('monthly_salary');
            $dailySalary = post_decimal('daily_salary');
            $hourlySalary = post_decimal('hourly_salary');

            $stmt = $connection->prepare(
                'SELECT id
                 FROM employee_positions
                 WHERE employee_id = ?
                 ORDER BY id DESC
                 LIMIT 1'
            );

            $stmt->bind_param('i', $employeeId);
            $stmt->execute();

            $positionResult = $stmt->get_result();

            if ($positionResult->num_rows > 0) {

                $positionRow = $positionResult->fetch_assoc();
                $employeePositionId = intval($positionRow['id']);

                $stmt = $connection->prepare(
                    'UPDATE employee_positions SET
                        department_id = ?,
                        position_id = ?,
                        date_start = ?,
                        date_end = ?,
                        monthly_salary = ?,
                        daily_salary = ?,
                        hourly_salary = ?
                    WHERE id = ?'
                );

                $stmt->bind_param(
                    'iissdddi',
                    $departmentId,
                    $positionId,
                    $dateStart,
                    $dateEnd,
                    $monthlySalary,
                    $dailySalary,
                    $hourlySalary,
                    $employeePositionId
                );

                $stmt->execute();

            } else {

                if (
                    $departmentId !== null ||
                    $positionId !== null ||
                    $dateStart !== null ||
                    $dateEnd !== null ||
                    $monthlySalary !== null ||
                    $dailySalary !== null ||
                    $hourlySalary !== null
                ) {

                    $stmt = $connection->prepare(
                        'INSERT INTO employee_positions (
                            employee_id,
                            department_id,
                            position_id,
                            date_start,
                            date_end,
                            monthly_salary,
                            daily_salary,
                            hourly_salary
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
                    );

                    $stmt->bind_param(
                        'iiissddd',
                        $employeeId,
                        $departmentId,
                        $positionId,
                        $dateStart,
                        $dateEnd,
                        $monthlySalary,
                        $dailySalary,
                        $hourlySalary
                    );

                    $stmt->execute();
                }
            }


            /*
             * Emergency Contact
             */

            $emergencyName = post_string('emergency_name');
            $emergencyRelationship = post_string('emergency_relationship');
            $emergencyAddress = post_string('emergency_address');
            $emergencyContactNo = post_string('emergency_contact_no');

            $stmt = $connection->prepare(
                'SELECT id
                 FROM emergency_contacts
                 WHERE employee_id = ?
                 ORDER BY id DESC
                 LIMIT 1'
            );

            $stmt->bind_param('i', $employeeId);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                $contactId = intval($row['id']);

                $stmt = $connection->prepare(
                    'UPDATE emergency_contacts SET
                        name = ?,
                        relationship = ?,
                        address = ?,
                        contact_no = ?
                    WHERE id = ?'
                );

                $stmt->bind_param(
                    'ssssi',
                    $emergencyName,
                    $emergencyRelationship,
                    $emergencyAddress,
                    $emergencyContactNo,
                    $contactId
                );

                $stmt->execute();

            } elseif (
                $emergencyName !== '' ||
                $emergencyRelationship !== '' ||
                $emergencyAddress !== '' ||
                $emergencyContactNo !== ''
            ) {

                $stmt = $connection->prepare(
                    'INSERT INTO emergency_contacts (
                        employee_id,
                        name,
                        relationship,
                        address,
                        contact_no
                    ) VALUES (?, ?, ?, ?, ?)'
                );

                $stmt->bind_param(
                    'issss',
                    $employeeId,
                    $emergencyName,
                    $emergencyRelationship,
                    $emergencyAddress,
                    $emergencyContactNo
                );

                $stmt->execute();
            }


            /*
             * Dependent
             */

            $dependentName = post_string('dependent_name');
            $dependentBirthdate = post_date('dependent_birthdate');
            $dependentRelationship = post_string('dependent_relationship');

            $stmt = $connection->prepare(
                'SELECT id
                 FROM dependents
                 WHERE employee_id = ?
                 ORDER BY id DESC
                 LIMIT 1'
            );

            $stmt->bind_param('i', $employeeId);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                $dependentId = intval($row['id']);

                $stmt = $connection->prepare(
                    'UPDATE dependents SET
                        name = ?,
                        birthdate = ?,
                        relationship = ?
                    WHERE id = ?'
                );

                $stmt->bind_param(
                    'sssi',
                    $dependentName,
                    $dependentBirthdate,
                    $dependentRelationship,
                    $dependentId
                );

                $stmt->execute();

            } elseif (
                $dependentName !== '' ||
                $dependentBirthdate !== null ||
                $dependentRelationship !== ''
            ) {

                $stmt = $connection->prepare(
                    'INSERT INTO dependents (
                        employee_id,
                        name,
                        birthdate,
                        relationship
                    ) VALUES (?, ?, ?, ?)'
                );

                $stmt->bind_param(
                    'isss',
                    $employeeId,
                    $dependentName,
                    $dependentBirthdate,
                    $dependentRelationship
                );

                $stmt->execute();
            }


            /*
             * Education
             */

            $school = post_string('school');
            $schoolAddress = post_string('school_address');
            $schoolYear = post_string('school_year');
            $educationLevel = post_string('education_level');

            $stmt = $connection->prepare(
                'SELECT id
                 FROM educational_backgrounds
                 WHERE employee_id = ?
                 ORDER BY id DESC
                 LIMIT 1'
            );

            $stmt->bind_param('i', $employeeId);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                $educationId = intval($row['id']);

                $stmt = $connection->prepare(
                    'UPDATE educational_backgrounds SET
                        school = ?,
                        address = ?,
                        school_year = ?,
                        level = ?
                    WHERE id = ?'
                );

                $stmt->bind_param(
                    'ssssi',
                    $school,
                    $schoolAddress,
                    $schoolYear,
                    $educationLevel,
                    $educationId
                );

                $stmt->execute();

            } elseif (
                $school !== '' ||
                $schoolAddress !== '' ||
                $schoolYear !== '' ||
                $educationLevel !== ''
            ) {

                $stmt = $connection->prepare(
                    'INSERT INTO educational_backgrounds (
                        employee_id,
                        school,
                        address,
                        school_year,
                        level
                    ) VALUES (?, ?, ?, ?, ?)'
                );

                $stmt->bind_param(
                    'issss',
                    $employeeId,
                    $school,
                    $schoolAddress,
                    $schoolYear,
                    $educationLevel
                );

                $stmt->execute();
            }


            /*
             * Character Reference
             */

            $referenceName = post_string('reference_name');
            $referenceOccupation = post_string('reference_occupation');
            $referenceAddress = post_string('reference_address');
            $referenceContact = post_string('reference_contact');

            $stmt = $connection->prepare(
                'SELECT id
                 FROM character_references
                 WHERE employee_id = ?
                 ORDER BY id DESC
                 LIMIT 1'
            );

            $stmt->bind_param('i', $employeeId);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                $referenceId = intval($row['id']);

                $stmt = $connection->prepare(
                    'UPDATE character_references SET
                        name = ?,
                        occupation = ?,
                        address = ?,
                        contact = ?
                    WHERE id = ?'
                );

                $stmt->bind_param(
                    'ssssi',
                    $referenceName,
                    $referenceOccupation,
                    $referenceAddress,
                    $referenceContact,
                    $referenceId
                );

                $stmt->execute();

            } elseif (
                $referenceName !== '' ||
                $referenceOccupation !== '' ||
                $referenceAddress !== '' ||
                $referenceContact !== ''
            ) {

                $stmt = $connection->prepare(
                    'INSERT INTO character_references (
                        employee_id,
                        name,
                        occupation,
                        address,
                        contact
                    ) VALUES (?, ?, ?, ?, ?)'
                );

                $stmt->bind_param(
                    'issss',
                    $employeeId,
                    $referenceName,
                    $referenceOccupation,
                    $referenceAddress,
                    $referenceContact
                );

                $stmt->execute();
            }


            $connection->commit();

            if ($newProfilePicture !== null) {

                $old = $connection->prepare(
                    'SELECT profile_picture
                     FROM employees
                     WHERE id = ?
                     LIMIT 1'
                );

                $old->bind_param('i', $employeeId);
                $old->execute();

                $oldResult = $old->get_result();

                if ($oldResult && $oldRow = $oldResult->fetch_assoc()) {

                    $oldPicture = $oldRow['profile_picture'] ?? '';

                    if (
                        $oldPicture !== '' &&
                        $oldPicture !== $newProfilePicture
                    ) {

                        $oldFile = __DIR__ . '/' . $oldPicture;

                        if (file_exists($oldFile)) {
                            @unlink($oldFile);
                        }
                    }
                }
            }

            flash_success('Employee updated successfully.');

        } catch (Throwable $e) {

            $connection->rollback();

            if (!empty($newProfilePicture)) {

                $file = __DIR__ . '/' . $newProfilePicture;

                if (file_exists($file)) {
                    @unlink($file);
                }
            }

            throw $e;
        }
    }


    /*
     * DELETE EMPLOYEE
     */

    if ($action === 'delete_employee') {

        $employeeId = intval($_POST['id'] ?? 0);

        if ($employeeId <= 0) {
            flash_error('Invalid employee.');
        }

        $connection->begin_transaction();

        try {

            $stmt = $connection->prepare(
                'SELECT profile_picture
                 FROM employees
                 WHERE id = ?
                 LIMIT 1'
            );

            $stmt->bind_param('i', $employeeId);
            $stmt->execute();

            $result = $stmt->get_result();

            $profilePicture = '';

            if ($result && $row = $result->fetch_assoc()) {
                $profilePicture = $row['profile_picture'] ?? '';
            }


            $tables = [
                'employee_positions',
                'emergency_contacts',
                'dependents',
                'educational_backgrounds',
                'character_references'
            ];

            foreach ($tables as $table) {

                $stmt = $connection->prepare(
                    "DELETE FROM {$table} WHERE employee_id = ?"
                );

                $stmt->bind_param('i', $employeeId);
                $stmt->execute();
            }


            $stmt = $connection->prepare(
                'DELETE FROM employees WHERE id = ?'
            );

            $stmt->bind_param('i', $employeeId);
            $stmt->execute();

            $connection->commit();


            if (
                $profilePicture !== '' &&
                file_exists(__DIR__ . '/' . $profilePicture)
            ) {
                @unlink(__DIR__ . '/' . $profilePicture);
            }

            flash_success('Employee deleted successfully.');

        } catch (Throwable $e) {

            $connection->rollback();

            throw $e;
        }
    }


    redirect_dashboard('home');

} catch (Throwable $e) {

    $_SESSION['flash_error'] =
        'Database error: ' . $e->getMessage();

    header('Location: dashboard.php#employees');
    exit;
}
?>