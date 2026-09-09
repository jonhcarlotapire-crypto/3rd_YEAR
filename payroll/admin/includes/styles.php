<style>

/* =========================================================
   GENERAL
========================================================= */

body {
    overflow-x: hidden;
    background-color: #f8fafc;
}

* {
    box-sizing: border-box;
}

.two-col {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.two-col .col {
    flex: 1;
    min-width: 260px;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
}

/* =========================================================
   EMPLOYEE SUBNAV
========================================================= */

.employees-subnav {
    display: none;
    width: 100%;
    overflow-x: auto;
    white-space: nowrap;

    gap: 6px;

    margin-bottom: 16px;
    padding: 10px;

    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 8px;

    -webkit-overflow-scrolling: touch;
}

.employees-subnav.show {
    display: flex !important;
}

.employee-tab {
    flex-shrink: 0;
    cursor: pointer;
}

.employee-tab.active {
    background-color: #0b69ff !important;
    color: #fff !important;
    font-weight: 600;

    box-shadow:
        0 4px 10px rgba(11, 105, 255, 0.2);
}

/* =========================================================
   EMPLOYEE FORM
========================================================= */

#emp-form.form-panel {
    position: static !important;

    display: none;

    width: 100% !important;
    max-width: none !important;

    margin: 18px 0 !important;

    padding: 20px;

    background: #ffffff;

    border: 1px solid #e2e8f0;
    border-radius: 12px;

    box-shadow:
        0 4px 12px rgba(0,0,0,0.05);
}

#emp-form.form-panel.show {
    display: block !important;
}

/*
   Important:
   We don't use the global .hidden class to control the
   employee form anymore. This prevents styles.css from
   interfering with the form fields.
*/

.employee-tab-content {
    display: none;
    width: 100%;
}

.employee-tab-content.show {
    display: block !important;
}

/* =========================================================
   FORM FIELDS
========================================================= */

#employee-form {
    width: 100%;
}

#employee-form input,
#employee-form select,
#employee-form textarea {
    width: 100%;

    padding: 10px;

    margin-top: 4px;

    border: 1px solid #cbd5e1;

    border-radius: 6px;

    font-size: 14px;

    background-color: #fff;

    color: #1e293b;

    box-sizing: border-box;
}

#employee-form input:focus,
#employee-form select:focus,
#employee-form textarea:focus {
    outline: none;

    border-color: #0b69ff;

    box-shadow:
        0 0 0 3px rgba(11, 105, 255, 0.10);
}

#employee-form textarea {
    resize: vertical;
    min-height: 70px;
}

#employee-form label {
    display: block;

    margin-bottom: 10px;

    font-weight: 500;

    font-size: 14px;

    color: #334155;
}

#employee-form input[type="file"] {
    padding: 8px;
}

/* =========================================================
   BUTTONS
========================================================= */

#employee-form button {
    cursor: pointer;
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .two-col {
        flex-direction: column;
        gap: 12px;
    }

    .container {
        padding: 10px;
    }

    .hero-grid {
        flex-direction: column;
    }

    .hero-stats {
        flex-direction: column;
    }

    table.table {
        font-size: 13px;
    }

    #emp-form.form-panel {
        padding: 15px;
    }

}

</style>
