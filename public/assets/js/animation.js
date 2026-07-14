/* =============================================
   BEAUTYCARE - ANIMATION JAVASCRIPT
   ============================================= */

'use strict';

document.addEventListener('DOMContentLoaded', function() {
  initFadeInAnimations();
  initHoverAnimations();
  initParallaxEffect();
});

/* ---- Fade In Animations ---- */
function initFadeInAnimations() {
  // Hero fade in on page load
  const heroContent = document.querySelector('.hero-content');
  const heroImage = document.querySelector('.hero-image');

  if (heroContent) {
    heroContent.style.opacity = '0';
    heroContent.style.transform = 'translateY(30px)';
    setTimeout(function() {
      heroContent.style.transition = 'all 0.8s ease-out';
      heroContent.style.opacity = '1';
      heroContent.style.transform = 'translateY(0)';
    }, 200);
  }

  if (heroImage) {
    heroImage.style.opacity = '0';
    heroImage.style.transform = 'translateX(30px)';
    setTimeout(function() {
      heroImage.style.transition = 'all 0.8s ease-out 0.3s';
      heroImage.style.opacity = '1';
      heroImage.style.transform = 'translateX(0)';
    }, 200);
  }

  // Staggered card animations
  const staggerContainers = document.querySelectorAll('.stagger-container');
  staggerContainers.forEach(function(container) {
    const items = container.querySelectorAll('.stagger-item');
    items.forEach(function(item, index) {
      item.style.opacity = '0';
      item.style.transform = 'translateY(20px)';

      const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            setTimeout(function() {
              item.style.transition = 'all 0.5s ease-out';
              item.style.opacity = '1';
              item.style.transform = 'translateY(0)';
            }, index * 100);
            observer.unobserve(item);
          }
        });
      }, { threshold: 0.1 });

      observer.observe(item);
    });
  });
}

/* ---- Hover Animations ---- */
function initHoverAnimations() {
  // Card hover effects (enhanced)
  const cards = document.querySelectorAll('.feature-card, .pricing-card, .testimoni-card, .layanan-card');
  cards.forEach(function(card) {
    card.addEventListener('mouseenter', function() {
      this.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
    });
  });

  // Button pulse effect on hover
  const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');
  buttons.forEach(function(btn) {
    btn.addEventListener('mouseenter', function() {
      this.style.transition = 'all 0.3s ease';
    });
  });
}

/* ---- Parallax Effect ---- */
function initParallaxEffect() {
  const parallaxElements = document.querySelectorAll('.parallax');

  if (parallaxElements.length === 0) return;

  window.addEventListener('scroll', function() {
    const scrollY = window.scrollY;

    parallaxElements.forEach(function(el) {
      const speed = el.getAttribute('data-speed') || 0.3;
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight && rect.bottom > 0) {
        el.style.transform = 'translateY(' + (scrollY * speed) + 'px)';
      }
    });
  });
}

/* ---- Skeleton Loading ---- */
function showSkeleton(container) {
  if (!container) return;
  const skeletonCount = container.getAttribute('data-skeleton') || 3;

  container.innerHTML = '';
  for (let i = 0; i < skeletonCount; i++) {
    const skeleton = document.createElement('div');
    skeleton.className = 'skeleton';
    skeleton.style.width = '100%';
    skeleton.style.height = '100px';
    skeleton.style.marginBottom = '12px';
    container.appendChild(skeleton);
  }
}

function hideSkeleton(container, content) {
  if (!container) return;
  container.innerHTML = content;
}

/* ---- Typing Effect ---- */
function typeWriter(element, text, speed) {
  if (!element) return;
  speed = speed || 50;
  let i = 0;

  function type() {
    if (i < text.length) {
      element.textContent += text.charAt(i);
      i++;
      setTimeout(type, speed);
    }
  }

  type();
}

/* ---- Number Counter with Easing ---- */
function animateCounter(element, target, duration, suffix) {
  if (!element) return;
  suffix = suffix || '';
  duration = duration || 2000;
  const start = 0;
  const startTime = performance.now();

  function easeOutCubic(t) {
    return 1 - Math.pow(1 - t, 3);
  }

  function update(currentTime) {
    const elapsed = currentTime - startTime;
    const progress = Math.min(elapsed / duration, 1);
    const easedProgress = easeOutCubic(progress);
    const current = Math.round(start + (target - start) * easedProgress);

    element.textContent = current.toLocaleString() + suffix;

    if (progress < 1) {
      requestAnimationFrame(update);
    }
  }

  requestAnimationFrame(update);
}
