 // Hero slider
  const slides = document.querySelectorAll('#heroSlider .slide');
  const dotsWrap = document.getElementById('sliderDots');
  let current = 0;
  slides.forEach((_, i) => {
    const dot = document.createElement('button');
    if (i === 0) dot.classList.add('active');
    dot.addEventListener('click', () => goToSlide(i));
    dotsWrap.appendChild(dot);
  });
  const dots = dotsWrap.querySelectorAll('button');
  function goToSlide(i){
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    current = i;
    slides[current].classList.add('active');
    dots[current].classList.add('active');
  }
  let autoSlide = setInterval(() => goToSlide((current + 1) % slides.length), 5000);
  document.getElementById('heroSlider').addEventListener('mouseenter', () => clearInterval(autoSlide));
  document.getElementById('heroSlider').addEventListener('mouseleave', () => {
    autoSlide = setInterval(() => goToSlide((current + 1) % slides.length), 5000);
  });

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