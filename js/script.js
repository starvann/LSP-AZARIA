 // Akademik tabs
  const tabBtns = document.querySelectorAll('.tab-btn');
  tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      tabBtns.forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
      btn.classList.add('active');
      document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
    });
  });

  // Mobile menu toggle
  const menuToggle = document.getElementById('menuToggle');
  const mainNav = document.querySelector('nav.main-nav');
  menuToggle.addEventListener('click', () => {
    const open = mainNav.style.display === 'flex';
    mainNav.style.display = open ? 'none' : 'flex';
    mainNav.style.cssText = open ? 'display:none;' : 'display:flex;position:absolute;top:100%;left:0;right:0;background:#F8FAFC;flex-direction:column;padding:20px 32px;gap:18px;border-bottom:1px solid #DCE6EF;';
  });
  document.querySelectorAll('nav.main-nav a').forEach(a => a.addEventListener('click', () => {
    if (window.innerWidth <= 980) { mainNav.style.display = 'none'; }
  }));

  // Back to top
  const backToTop = document.getElementById('backToTop');
  window.addEventListener('scroll', () => {
    backToTop.classList.toggle('show', window.scrollY > 500);
  });
  backToTop.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));