<!-- =========================================================
     HEADER (Updated with Responsive Mobile Dropdown for Employees & Departments)
========================================================= -->

<header class="nav">

    <div class="nav-inner">

        <a
            class="nav-brand"
            href="dashboard.php"
        >

            <img
                src="assets/images/lcc.png"
                alt="Logo"
            >

            <div>

                <span class="brand">
                    LCC Payroll Admin
                </span>

                <span class="nav-sublabel">
                    LCC payroll system
                </span>

            </div>

        </a>

        <button
            id="nav-toggle"
            class="nav-toggle"
            aria-label="Toggle navigation"
        >
            ☰
        </button>

        <nav
            id="nav-menu"
            class="nav-menu"
        >

            <a
                href="#"
                data-target="home"
                class="nav-link active"
            >
                Dashboard
            </a>

            <!-- Dropdown Container for Organization Management -->
            <div class="nav-dropdown" id="org-dropdown">
                <button type="button" class="nav-link dropdown-toggle" aria-expanded="false">
                    Employees <span class="dropdown-caret">▾</span>
                </button>
                <div class="dropdown-menu">
                    <a
                        href="#"
                        data-target="dept-pos"
                        class="nav-link dropdown-item"
                    >
                        Departments & Positions
                    </a>

                    <a
                        href="#"
                        data-target="employees"
                        class="nav-link dropdown-item"
                    >
                        Employees
                    </a>
                </div>
            </div>
            <a
                href="1"
                data-target="1"
                class="1"
            >
                Payroll
            </a>
            <a
                href="2"
                data-target="2"
                class="2"
            >
                Loans
            </a>
            <a
                href="logout.php"
                class="nav-link nav-link--logout"
            >
                Logout
            </a>

        </nav>

    </div>

</header>

<div
    id="mobile-overlay"
    class="mobile-overlay"
></div>

<style>
/* =========================================================
   Responsive Navigation Dropdown Additions
   ========================================================= */
.nav-dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-toggle {
  background: transparent;
  border: none;
  font-family: inherit;
  font-size: 0.95rem;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 4px;
}

.dropdown-caret {
  font-size: 0.75rem;
  transition: transform 0.2s ease;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  min-width: 180px;
  background: var(--surface, #ffffff);
  border: 1px solid var(--border-color, #e2e8f0);
  border-radius: var(--radius-sm, 8px);
  box-shadow: var(--shadow-md, 0 4px 6px -1px rgba(0, 0, 0, 0.1));
  padding: 6px;
  display: none;
  z-index: 1000;
  animation: fadeInDown 0.2s ease forwards;
}

@keyframes fadeInDown {
  from { opacity: 0; transform: translateY(-6px); }
  to { opacity: 1; transform: translateY(0); }
}

.nav-dropdown:hover .dropdown-menu,
.nav-dropdown.active .dropdown-menu {
  display: block;
}

.nav-dropdown:hover .dropdown-caret {
  transform: rotate(180deg);
}

.dropdown-item {
  padding: 10px 14px !important;
  border-radius: 6px !important;
  color: var(--text-main, #0f172a) !important;
  font-weight: 500 !important;
}

.dropdown-item:hover {
  background: var(--primary-light, #eff6ff) !important;
  color: var(--primary, #2563eb) !important;
  transform: none !important;
}

/* Mobile Adjustments for Dropdowns */
@media (max-width: 768px) {
  .nav-dropdown {
    width: 100%;
    display: block;
  }

  .dropdown-toggle {
    width: 100%;
    justify-content: space-between;
    padding: 12px 16px;
    border-radius: var(--radius-sm, 8px);
    color: var(--text-muted, #64748b);
  }

  .dropdown-toggle:hover {
    background: var(--primary-light, #eff6ff);
    color: var(--primary, #2563eb);
  }

  .dropdown-menu {
    position: static;
    box-shadow: none;
    border: none;
    background: transparent;
    padding: 0 0 0 16px;
    display: none;
    width: 100%;
  }

  .nav-dropdown.active .dropdown-menu {
    display: block;
  }
}
</style>

<script>
/* =========================================================
   Mobile Touch & Click Handler for Dropdown Toggle
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {
  const dropdownToggle = document.querySelector('.dropdown-toggle');
  const dropdownParent = document.getElementById('org-dropdown');

  if (dropdownToggle && dropdownParent) {
    dropdownToggle.addEventListener('click', (e) => {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        dropdownParent.classList.toggle('active');
      }
    });
  }
});
</script>