<script src="assets/js/script.js"></script>

<!-- EMPLOYEE MANAGEMENT SCRIPT -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const employeeForm =
        document.getElementById('employee-form');

    const employeeAction =
        document.getElementById('employee-form-action');

    const employeeEditId =
        document.getElementById('employee-edit-id');

    const employeeSubmit =
        document.getElementById('employee-submit');

    const empFormPanel =
        document.getElementById('emp-form');

    const employeesSubnav =
        document.getElementById('employees-subnav');

    const addEmployeeButton =
        document.getElementById('add-employee-button');

    const cancelEmployeeButton =
        document.getElementById('cancel-employee');


    /* =====================================================
       SET FIELD VALUE
    ===================================================== */

    function setValue(name, value) {

        if (!employeeForm) {
            return;
        }

        const field =
            employeeForm.querySelector(
                '[name="' + name + '"]'
            );

        if (field) {

            field.value =
                value == null
                    ? ''
                    : value;

        }

    }


    /* =====================================================
       SHOW EMPLOYEE FORM
    ===================================================== */

    function showEmployeeForm() {

        if (empFormPanel) {

            empFormPanel.classList.add('show');
            empFormPanel.classList.remove('hidden');

        }

        if (employeesSubnav) {

            employeesSubnav.classList.add('show');

            employeesSubnav.style.display = 'flex';

        }

    }


    /* =====================================================
       HIDE EMPLOYEE FORM
    ===================================================== */

    function hideEmployeeForm() {

        if (empFormPanel) {

            empFormPanel.classList.remove('show');

            empFormPanel.classList.add('hidden');

        }

        if (employeesSubnav) {

            employeesSubnav.classList.remove('show');

            employeesSubnav.style.display = 'none';

        }

    }


    /* =====================================================
       SHOW TAB
    ===================================================== */

    function showEmployeeTab(tabId) {

        document
            .querySelectorAll('.employee-tab')
            .forEach(function (tab) {

                tab.classList.toggle(
                    'active',
                    tab.getAttribute(
                        'data-employee-tab'
                    ) === tabId
                );

            });


        document
            .querySelectorAll('.employee-tab-content')
            .forEach(function (content) {

                content.classList.remove('show');

                content.classList.add('hidden');

            });


        const target =
            document.getElementById(tabId);

        if (target) {

            target.classList.remove('hidden');

            target.classList.add('show');

        }

    }


    /* =====================================================
       ADD MODE
    ===================================================== */

    function setAddMode() {

        if (!employeeForm) {
            return;
        }

        employeeForm.reset();

        employeeAction.value =
            'add_employee';

        employeeEditId.value =
            '';

        setValue(
            'nationality',
            'Filipino'
        );

        if (employeeSubmit) {

            employeeSubmit.textContent =
                'Save Employee';

        }

        if (addEmployeeButton) {

            addEmployeeButton.textContent =
                '+ Add Employee';

        }

        showEmployeeForm();

        showEmployeeTab(
            'personal-info'
        );

        setTimeout(function () {

            if (empFormPanel) {

                empFormPanel.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

            }

        }, 100);

    }


    /* =====================================================
       ADD EMPLOYEE BUTTON
    ===================================================== */

    if (addEmployeeButton) {

        addEmployeeButton.addEventListener(
            'click',
            function (event) {

                event.preventDefault();

                setAddMode();

            }
        );

    }


    /* =====================================================
       EMPLOYEE TABS
    ===================================================== */

    document
        .querySelectorAll('.employee-tab')
        .forEach(function (tab) {

            tab.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    showEmployeeForm();

                    showEmployeeTab(
                        this.getAttribute(
                            'data-employee-tab'
                        )
                    );

                }
            );

        });


    /* =====================================================
       EDIT EMPLOYEE
    ===================================================== */

    document
        .querySelectorAll('.edit-employee')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    if (!employeeForm) {
                        return;
                    }

                    const d =
                        this.dataset;


                    employeeAction.value =
                        'update_employee';

                    employeeEditId.value =
                        d.id || '';


                    showEmployeeForm();

                    showEmployeeTab(
                        'personal-info'
                    );


                    /* PERSONAL */

                    setValue(
                        'employee_no',
                        d.employeeNo
                    );

                    setValue(
                        'first_name',
                        d.firstName
                    );

                    setValue(
                        'middle_name',
                        d.middleName
                    );

                    setValue(
                        'last_name',
                        d.lastName
                    );

                    setValue(
                        'gender',
                        d.gender
                    );

                    setValue(
                        'email',
                        d.email
                    );

                    setValue(
                        'phone',
                        d.phone
                    );

                    setValue(
                        'civil_status',
                        d.civilStatus
                    );

                    setValue(
                        'nationality',
                        d.nationality
                    );

                    setValue(
                        'religion',
                        d.religion
                    );

                    setValue(
                        'birthdate',
                        d.birthdate
                    );

                    setValue(
                        'present_address',
                        d.presentAddress
                    );

                    setValue(
                        'permanent_address',
                        d.permanentAddress
                    );

                    setValue(
                        'sss_no',
                        d.sssNo
                    );

                    setValue(
                        'philhealth_no',
                        d.philhealthNo
                    );

                    setValue(
                        'pagibig_no',
                        d.pagibigNo
                    );

                    setValue(
                        'atm_no',
                        d.atmNo
                    );

                    setValue(
                        'tin_no',
                        d.tinNo
                    );

                    /* EMERGENCY */

                    setValue(
                        'emergency_name',
                        d.emergencyName
                    );

                    setValue(
                        'emergency_relationship',
                        d.emergencyRelationship
                    );

                    setValue(
                        'emergency_address',
                        d.emergencyAddress
                    );

                    setValue(
                        'emergency_contact_no',
                        d.emergencyContactNo
                    );

                    /* DEPENDENT */

                    setValue(
                        'dependent_name',
                        d.dependentName
                    );

                    setValue(
                        'dependent_birthdate',
                        d.dependentBirthdate
                    );

                    setValue(
                        'dependent_relationship',
                        d.dependentRelationship
                    );

                    /* EDUCATION */

                    setValue(
                        'school',
                        d.school
                    );

                    setValue(
                        'school_address',
                        d.schoolAddress
                    );

                    setValue(
                        'school_year',
                        d.schoolYear
                    );

                    setValue(
                        'education_level',
                        d.educationLevel
                    );

                    /* CHARACTER REFERENCE */

                    setValue(
                        'reference_name',
                        d.referenceName
                    );

                    setValue(
                        'reference_occupation',
                        d.referenceOccupation
                    );

                    setValue(
                        'reference_address',
                        d.referenceAddress
                    );

                    setValue(
                        'reference_contact',
                        d.referenceContact
                    );

                    /* POSITION & SALARY */

                    setValue(
                        'department_id',
                        d.departmentId
                    );

                    setValue(
                        'position_id',
                        d.positionId
                    );

                    setValue(
                        'date_start',
                        d.dateStart
                    );

                    setValue(
                        'date_end',
                        d.dateEnd
                    );

                    setValue(
                        'monthly_salary',
                        d.monthlySalary
                    );

                    setValue(
                        'daily_salary',
                        d.dailySalary
                    );

                    setValue(
                        'hourly_salary',
                        d.hourlySalary
                    );


                    if (employeeSubmit) {

                        employeeSubmit.textContent =
                            'Update Employee';

                    }

                    if (addEmployeeButton) {

                        addEmployeeButton.textContent =
                            'Edit Employee';

                    }


                    setTimeout(function () {

                        if (empFormPanel) {

                            empFormPanel.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });

                        }

                    }, 100);

                }
            );

        });


    if (cancelEmployeeButton) {

        cancelEmployeeButton.addEventListener(
            'click',
            function () {

                if (employeeForm) {

                    employeeForm.reset();

                }

                employeeAction.value =
                    'add_employee';

                employeeEditId.value =
                    '';

                setValue(
                    'nationality',
                    'Filipino'
                );

                if (employeeSubmit) {

                    employeeSubmit.textContent =
                        'Save Employee';

                }

                if (addEmployeeButton) {

                    addEmployeeButton.textContent =
                        '+ Add Employee';

                }

                hideEmployeeForm();

                showEmployeeTab(
                    'personal-info'
                );

            }
        );

    }

    hideEmployeeForm();

});

</script>
