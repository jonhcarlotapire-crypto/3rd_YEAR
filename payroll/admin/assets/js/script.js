document.addEventListener('DOMContentLoaded', function(){
  var toggle = document.getElementById('nav-toggle');
  var menu = document.getElementById('nav-menu');
  var overlay = document.getElementById('mobile-overlay');
  var sectionLinks = document.querySelectorAll('#nav-menu a[data-target]');
  
  var sections = {
    home: document.getElementById('home'),
    'dept-pos': document.getElementById('dept-pos'),
    employees: document.getElementById('employees')
  };

  function setActiveLink(target) {
    sectionLinks.forEach(function(link) {
      link.classList.toggle('active', link.dataset.target === target);
    });
  }

  function showSection(target) {
    Object.keys(sections).forEach(function(name) {
      if (!sections[name]) return;
      sections[name].classList.toggle('hidden', name !== target);
    });
    setActiveLink(target);
  }

  if (toggle && menu) {
    toggle.addEventListener('click', function(){
      menu.classList.toggle('open');
      toggle.textContent = menu.classList.contains('open') ? '✕' : '☰';
    });
  }

  sectionLinks.forEach(function(link) {
    link.addEventListener('click', function(event) {
      event.preventDefault();
      var target = link.dataset.target;
      showSection(target);
      
      if (menu) menu.classList.remove('open');
      if (toggle) toggle.textContent = '☰';
      
      if (target === 'dept-pos') {
        history.replaceState(null, '', '#dept-pos');
      } else if (target === 'employees') {
        history.replaceState(null, '', '#employees');
      } else {
        history.replaceState(null, '', 'dashboard.php');
      }
    });
  });

  if (overlay) {
    overlay.addEventListener('click', function(){
      if (menu) menu.classList.remove('open');
      if (toggle) toggle.textContent = '☰';
    });
  }

  // --- EMPLOYEE SUB-TABS SWITCHER ---
  document.addEventListener('click', function(e) {
    var tabBtn = e.target.closest('.employee-tab');
    if (tabBtn) {
      e.preventDefault();
      
      document.querySelectorAll('.employee-tab').forEach(function(btn) {
        btn.classList.remove('active');
      });
      document.querySelectorAll('.employee-tab-content').forEach(function(content) {
        content.classList.add('hidden');
      });

      tabBtn.classList.add('active');
      var targetId = tabBtn.getAttribute('data-employee-tab');
      var targetContent = document.getElementById(targetId);
      if (targetContent) {
        targetContent.classList.remove('hidden');
      }
    }
  });

  // Modal Handlers for Departments/Positions
  var editModal = document.getElementById('edit-modal');
  var editForm = document.getElementById('edit-form');
  var editTitle = document.getElementById('edit-title');
  var editCancel = document.getElementById('edit-cancel');

  document.addEventListener('click', function(e){
    var editBtn = e.target.closest && e.target.closest('button[data-action="edit-dept"]');
    if (editBtn) {
      var id = editBtn.getAttribute('data-id');
      var name = editBtn.getAttribute('data-name');
      if (editTitle) editTitle.textContent = 'Edit Department';
      if (editForm) {
        editForm.action = 'actions.php';
        editForm.querySelector('input[name="action"]').value = 'update_department';
        editForm.querySelector('input[name="id"]').value = id;
        editForm.querySelector('input[name="name"]').value = name;
      }
      if (editModal) editModal.classList.remove('hidden');
      return;
    }

    editBtn = e.target.closest && e.target.closest('button[data-action="edit-pos"]');
    if (editBtn) {
      var id = editBtn.getAttribute('data-id');
      var name = editBtn.getAttribute('data-name');
      if (editTitle) editTitle.textContent = 'Edit Position';
      if (editForm) {
        editForm.action = 'actions.php';
        editForm.querySelector('input[name="action"]').value = 'update_position';
        editForm.querySelector('input[name="id"]').value = id;
        editForm.querySelector('input[name="name"]').value = name;
      }
      if (editModal) editModal.classList.remove('hidden');
      return;
    }
  });

  if (editCancel) editCancel.addEventListener('click', function(){ editModal.classList.add('hidden'); });

  // Add / Cancel Toggles (Departments, Positions, Employees)
  document.addEventListener('click', function(e){
    var addBtn = e.target.closest && e.target.closest('.btn-add');
    if (addBtn) {
      var target = addBtn.getAttribute('data-target');
      var panel = document.getElementById(target);
      if (panel) panel.classList.toggle('hidden');

      if (target === 'emp-form') {
        var subnav = document.getElementById('employees-subnav');
        var isHidden = panel.classList.contains('hidden');
        
        if (subnav) subnav.style.display = isHidden ? 'none' : 'flex';
        
        if (!isHidden) {
          document.querySelectorAll('.employee-tab').forEach(btn => btn.classList.remove('active'));
          document.querySelectorAll('.employee-tab-content').forEach(c => c.classList.add('hidden'));
          
          var firstTabBtn = document.querySelector('[data-employee-tab="personal-info"]');
          var firstTabContent = document.getElementById('personal-info');
          if (firstTabBtn) firstTabBtn.classList.add('active');
          if (firstTabContent) firstTabContent.classList.remove('hidden');

          var form = document.getElementById('employee-form');
          if (form) form.reset();
          var actionInput = document.getElementById('employee-form-action');
          if (actionInput) actionInput.value = 'add_employee';
          var idInput = document.getElementById('employee-edit-id');
          if (idInput) idInput.value = '';
          var submitBtn = document.getElementById('employee-submit');
          if (submitBtn) submitBtn.textContent = 'Save Employee';
          
          panel.scrollIntoView({behavior: 'smooth', block: 'start'});
        }
      }
      return;
    }

    var cancelBtn = e.target.closest && e.target.closest('button[data-action="cancel"]');
    if (cancelBtn) {
      var t = cancelBtn.getAttribute('data-target');
      var p = document.getElementById(t);
      if (p) p.classList.add('hidden');

      if (t === 'emp-form') {
        var subnav = document.getElementById('employees-subnav');
        if (subnav) subnav.style.display = 'none';
        document.querySelectorAll('.employee-tab-content').forEach(c => c.classList.add('hidden'));
      }
      return;
    }
  });

  if (window.location.hash === '#dept-pos') {
    showSection('dept-pos');
  } else if (window.location.hash === '#employees') {
    showSection('employees');
  } else {
    showSection('home');
  }
});