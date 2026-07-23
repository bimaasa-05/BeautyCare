/* =============================================
   BEAUTYCARE - DASHBOARD JAVASCRIPT
   ============================================= */

'use strict';

document.addEventListener('DOMContentLoaded', function() {
  initPageLoader();
  initSidebar();
  initCharts();
  initNotifications();
});

/* ---- Page Loader ---- */
function initPageLoader() {
  const loader = document.querySelector('.page-loader');
  if (loader) {
    setTimeout(function() {
      loader.classList.add('hidden');
    }, 500);
  }
}

/* ---- Sidebar Toggle ---- */
function initSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const toggleBtn = document.querySelector('.sidebar-toggle');
  const overlay = document.querySelector('.sidebar-overlay');

  if (toggleBtn) {
    toggleBtn.addEventListener('click', function() {
      sidebar.classList.toggle('open');
      if (overlay) overlay.classList.toggle('active');
    });
  }

  if (overlay) {
    overlay.addEventListener('click', function() {
      sidebar.classList.remove('open');
      overlay.classList.remove('active');
    });
  }

  // Submenu toggle
  const navItems = document.querySelectorAll('.nav-item.has-sub');
  navItems.forEach(function(item) {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      const arrow = this.querySelector('.nav-arrow');
      const subNav = this.nextElementSibling;

      if (arrow && subNav) {
        arrow.classList.toggle('open');
        subNav.classList.toggle('open');
      }
    });
  });
}

/* ---- Charts (Canvas) ---- */
function initCharts() {
  const bookingCanvas = document.getElementById('chartBooking');
  if (bookingCanvas) {
    drawBookingChart(bookingCanvas);
  }
}

function drawBookingChart(canvas) {
  const ctx = canvas.getContext('2d');
  const dpr = window.devicePixelRatio || 1;

  const rect = canvas.getBoundingClientRect();
  canvas.width = rect.width * dpr;
  canvas.height = rect.height * dpr;
  ctx.scale(dpr, dpr);

  const width = rect.width;
  const height = rect.height;
  const padding = { top: 20, bottom: 25, left: 30, right: 10 };
  const chartW = width - padding.left - padding.right;
  const chartH = height - padding.top - padding.bottom;

  const labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
  const data = [18, 25, 20, 30, 28, 40, 35];
  const maxVal = Math.max(...data) * 1.2;
  const barWidth = chartW / labels.length * 0.5;
  const gap = chartW / labels.length;

  // Grid
  ctx.strokeStyle = '#ECECEC';
  ctx.lineWidth = 1;
  for (let i = 0; i <= 4; i++) {
    const y = padding.top + chartH - (chartH / 4) * i;
    ctx.beginPath();
    ctx.moveTo(padding.left, y);
    ctx.lineTo(width - padding.right, y);
    ctx.stroke();
  }

  // Bars
  labels.forEach(function(label, i) {
    const x = padding.left + gap * i + (gap - barWidth) / 2;
    const barH = (data[i] / maxVal) * chartH;
    const y = padding.top + chartH - barH;

    // Rounded top bar
    ctx.beginPath();
    const radius = 4;
    ctx.moveTo(x, y + radius);
    ctx.arcTo(x, y, x + radius, y, radius);
    ctx.lineTo(x + barWidth - radius, y);
    ctx.arcTo(x + barWidth, y, x + barWidth, y + radius, radius);
    ctx.lineTo(x + barWidth, padding.top + chartH);
    ctx.lineTo(x, padding.top + chartH);
    ctx.closePath();

    ctx.fillStyle = '#FF4F87';
    ctx.globalAlpha = 0.8;
    ctx.fill();
    ctx.globalAlpha = 1;

    // X labels
    ctx.fillStyle = '#999';
    ctx.font = '10px Poppins, sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText(label, x + barWidth / 2, height - padding.bottom + 16);
  });

  // Total
  ctx.fillStyle = '#333';
  ctx.font = '11px Poppins, sans-serif';
  ctx.textAlign = 'left';
  ctx.fillText('Total: ' + data.reduce(function(a, b) { return a + b; }), padding.left, 16);
}

/* ---- Notification Dropdown ---- */

/* ---- Toast Notifications ---- */
function showToast(message, type) {
  type = type || 'success';
  var container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  var icons = {
    success: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
    error: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
    warning: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
    info: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
  };

  var titles = {
    success: 'Berhasil!',
    error: 'Gagal!',
    warning: 'Peringatan!',
    info: 'Informasi'
  };

  var toast = document.createElement('div');
  toast.className = 'toast-item toast-' + type;
  toast.innerHTML =
    '<div class="toast-icon">' + (icons[type] || icons.success) + '</div>' +
    '<div class="toast-content">' +
      '<h4>' + (titles[type] || '') + '</h4>' +
      '<p>' + message + '</p>' +
    '</div>' +
    '<button class="toast-close" onclick="this.parentElement.remove()">' +
      '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
    '</button>';

  container.appendChild(toast);

  if (type === 'success') {
    playSuccessSound();
  } else if (type === 'warning') {
    playWarningSound();
  }

  requestAnimationFrame(function() {
    toast.classList.add('show');
  });

  setTimeout(function() {
    toast.classList.remove('show');
    setTimeout(function() { if (toast.parentNode) toast.remove(); }, 400);
  }, 4000);
}

document.addEventListener('DOMContentLoaded', function() {
  var toastEl = document.getElementById('session-toast');
  if (toastEl) {
    var message = toastEl.getAttribute('data-message');
    var type = toastEl.getAttribute('data-type') || 'success';
    if (message) showToast(message, type);
  }
});

/* ---- Responsive Charts ---- */
/* ---- Notifikasi Suara "Ting" ---- */
function playSuccessSound() {
    try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.connect(gain);
        gain.connect(ctx.destination);

        osc.frequency.value = 880;
        osc.type = 'sine';

        gain.gain.setValueAtTime(0.3, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);

        osc.start(ctx.currentTime);
        osc.stop(ctx.currentTime + 0.4);
    } catch(e) {
        console.log('Audio not supported');
    }
}

/* ---- Notifikasi Suara Peringatan ---- */
function playWarningSound() {
    try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.connect(gain);
        gain.connect(ctx.destination);

        osc.frequency.value = 440;
        osc.type = 'square';

        gain.gain.setValueAtTime(0.2, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.6);

        osc.start(ctx.currentTime);
        osc.stop(ctx.currentTime + 0.6);
    } catch(e) {
        console.log('Audio not supported');
    }
}

window.addEventListener('resize', function() {
  const bookingCanvas = document.getElementById('chartBooking');
  if (bookingCanvas) {
    clearTimeout(window._chartResize2);
    window._chartResize2 = setTimeout(function() {
      drawBookingChart(bookingCanvas);
    }, 300);
  }
});
