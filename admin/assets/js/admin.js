/* =========================================================
   ADMIN PANEL JS - SMK NEGERI 1 KANDEMAN
   Interaksi UI sederhana: sidebar toggle & modal hapus (placeholder)
   Belum ada koneksi backend / database.
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

  /* ---------- SIDEBAR TOGGLE (mobile) ---------- */
  var sidebar = document.getElementById('sidebar');
  var backdrop = document.getElementById('sidebarBackdrop');
  var openBtn = document.getElementById('menuToggleBtn');
  var closeBtn = document.getElementById('sidebarCloseBtn');

  function openSidebar() {
    if (sidebar) sidebar.classList.add('open');
    if (backdrop) backdrop.classList.add('open');
  }
  function closeSidebar() {
    if (sidebar) sidebar.classList.remove('open');
    if (backdrop) backdrop.classList.remove('open');
  }

  if (openBtn) openBtn.addEventListener('click', openSidebar);
  if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
  if (backdrop) backdrop.addEventListener('click', closeSidebar);

  /* ---------- MODAL HAPUS ---------- */
  /* Tombol hapus butuh atribut:
       data-delete-target = label yang ditampilkan di modal
       data-delete-id     = id baris yang akan dihapus (dikirim ke hapus.php)
     Saat dikonfirmasi, browser diarahkan ke hapus.php?id=... (relatif terhadap folder modul saat ini). */
  var deleteModal = document.getElementById('deleteModal');
  var deleteTargetLabel = document.getElementById('deleteTargetLabel');
  var deleteButtons = document.querySelectorAll('[data-delete-target]');
  var modalCancelBtns = document.querySelectorAll('[data-modal-cancel]');
  var modalConfirmBtn = document.getElementById('deleteConfirmBtn');
  var pendingDeleteId = null;

  deleteButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var label = btn.getAttribute('data-delete-target');
      pendingDeleteId = btn.getAttribute('data-delete-id');
      if (deleteTargetLabel && label) {
        deleteTargetLabel.textContent = label;
      }
      if (deleteModal) deleteModal.classList.add('open');
    });
  });

  modalCancelBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      pendingDeleteId = null;
      if (deleteModal) deleteModal.classList.remove('open');
    });
  });

  if (deleteModal) {
    deleteModal.addEventListener('click', function (e) {
      if (e.target === deleteModal) {
        pendingDeleteId = null;
        deleteModal.classList.remove('open');
      }
    });
  }

  if (modalConfirmBtn) {
    modalConfirmBtn.addEventListener('click', function () {
      if (deleteModal) deleteModal.classList.remove('open');
      if (pendingDeleteId) {
        window.location.href = 'hapus.php?id=' + encodeURIComponent(pendingDeleteId);
      }
    });
  }

  /* ---------- TOGGLE SHOW/HIDE PASSWORD (login) ---------- */
  var toggleBtn = document.getElementById('togglePassword');
  var passwordInput = document.getElementById('password');
  if (toggleBtn && passwordInput) {
    toggleBtn.addEventListener('click', function () {
      var isHidden = passwordInput.type === 'password';
      passwordInput.type = isHidden ? 'text' : 'password';
    });
  }

});
