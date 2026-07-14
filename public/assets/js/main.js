/* =============================================
   BEAUTYCARE - MAIN JAVASCRIPT
   ============================================= */

'use strict';

document.addEventListener('DOMContentLoaded', function() {
  initNavbar();
  initScrollAnimations();
  initFaq();
  initTestimonialSlider();
  initCounters();
  initSmoothScroll();
});

/* ---- Navbar Toggle & Scroll ---- */
function initNavbar() {
  const navbar = document.querySelector('.navbar');
  const toggle = document.querySelector('.navbar-toggle');
  const navMenu = document.querySelector('.navbar-nav');

  if (toggle) {
    toggle.addEventListener('click', function() {
      this.classList.toggle('active');
      navMenu.classList.toggle('open');
    });
  }

  if (navbar) {
    window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  }

  // Close menu on link click
  if (navMenu) {
    navMenu.querySelectorAll('a').forEach(function(link) {
      link.addEventListener('click', function() {
        navMenu.classList.remove('open');
        if (toggle) toggle.classList.remove('active');
      });
    });
  }
}

/* ---- Scroll Animations ---- */
function initScrollAnimations() {
  const elements = document.querySelectorAll('.animate-on-scroll');

  if (elements.length === 0) return;

  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  });

  elements.forEach(function(el) {
    observer.observe(el);
  });
}

/* ---- FAQ Accordion ---- */
function initFaq() {
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(function(item) {
    const question = item.querySelector('.faq-question');

    question.addEventListener('click', function() {
      const isActive = item.classList.contains('active');

      faqItems.forEach(function(other) {
        other.classList.remove('active');
      });

      if (!isActive) {
        item.classList.add('active');
      }
    });
  });
}

/* ---- Testimonial Slider ---- */
function initTestimonialSlider() {
  const track = document.querySelector('.testimoni-track');
  const dots = document.querySelectorAll('.slider-dots .dot');

  if (!track || dots.length === 0) return;

  let currentIndex = 0;
  const totalSlides = dots.length;

  function goToSlide(index) {
    if (index < 0) index = 0;
    if (index >= totalSlides) index = 0;
    currentIndex = index;

    const card = track.querySelector('.testimoni-card');
    if (card) {
      const cardWidth = card.offsetWidth + 24;
      track.style.transform = 'translateX(-' + (cardWidth * currentIndex) + 'px)';
    }

    dots.forEach(function(dot, i) {
      dot.classList.toggle('active', i === currentIndex);
    });
  }

  dots.forEach(function(dot, index) {
    dot.addEventListener('click', function() {
      goToSlide(index);
    });
  });

  // Auto slide
  setInterval(function() {
    goToSlide(currentIndex + 1);
  }, 5000);

  // Responsive: recalculate on resize
  window.addEventListener('resize', function() {
    goToSlide(currentIndex);
  });
}

/* ---- Counter Animation ---- */
function initCounters() {
  const counters = document.querySelectorAll('.stat-card h3');

  counters.forEach(function(counter) {
    const targetText = counter.textContent;
    const target = parseInt(targetText.replace(/[^0-9]/g, ''));
    if (isNaN(target)) return;

    const suffix = targetText.replace(/[0-9]/g, '');
    const duration = 2000;
    const step = Math.max(1, Math.floor(target / 60));
    let current = 0;

    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          const timer = setInterval(function() {
            current += step;
            if (current >= target) {
              current = target;
              clearInterval(timer);
            }
            counter.textContent = current.toLocaleString() + suffix;
          }, duration / 60);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    observer.observe(counter);
  });
}

/* ---- Smooth Scroll ---- */
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      if (targetId === '#') return;

      const target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        const offsetTop = target.offsetTop - 80;
        window.scrollTo({
          top: offsetTop,
          behavior: 'smooth'
        });
      }
    });
  });
}
