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
  const pendapatanCanvas = document.getElementById('chartPendapatan');
  if (pendapatanCanvas) {
    drawPendapatanChart(pendapatanCanvas);
  }

  const bookingCanvas = document.getElementById('chartBooking');
  if (bookingCanvas) {
    drawBookingChart(bookingCanvas);
  }

  drawMiniCharts();
}

function drawPendapatanChart(canvas) {
  const ctx = canvas.getContext('2d');
  const dpr = window.devicePixelRatio || 1;

  const rect = canvas.getBoundingClientRect();
  canvas.width = rect.width * dpr;
  canvas.height = rect.height * dpr;
  ctx.scale(dpr, dpr);

  const width = rect.width;
  const height = rect.height;
  const padding = { top: 20, bottom: 30, left: 40, right: 20 };
  const chartW = width - padding.left - padding.right;
  const chartH = height - padding.top - padding.bottom;

  // Data
  const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
  const data = [12, 19, 15, 25, 22, 30, 28, 35, 32, 40, 38, 48];
  const data2 = [8, 14, 11, 18, 16, 22, 20, 26, 24, 30, 28, 35];

  const maxVal = Math.max(...data, ...data2) * 1.2;
  const stepY = maxVal / 5;
  const stepX = chartW / (labels.length - 1);

  // Grid lines
  ctx.strokeStyle = '#ECECEC';
  ctx.lineWidth = 1;
  ctx.setLineDash([]);

  for (let i = 0; i <= 5; i++) {
    const y = padding.top + chartH - (chartH / 5) * i;
    ctx.beginPath();
    ctx.moveTo(padding.left, y);
    ctx.lineTo(width - padding.right, y);
    ctx.stroke();

    // Y-axis labels
    ctx.fillStyle = '#999';
    ctx.font = '11px Poppins, sans-serif';
    ctx.textAlign = 'right';
    ctx.fillText(Math.round(maxVal / 5 * i).toString(), padding.left - 10, y + 4);
  }

  // X-axis labels
  ctx.fillStyle = '#999';
  ctx.font = '11px Poppins, sans-serif';
  ctx.textAlign = 'center';
  labels.forEach(function(label, i) {
    const x = padding.left + (chartW / (labels.length - 1)) * i;
    ctx.fillText(label, x, height - padding.bottom + 18);
  });

  // Draw line function
  function drawLine(dataArray, color, gradientColor) {
    // Gradient fill
    const gradient = ctx.createLinearGradient(0, padding.top, 0, height - padding.bottom);
    gradient.addColorStop(0, gradientColor);
    gradient.addColorStop(1, 'rgba(255, 79, 135, 0)');

    // Fill area
    ctx.beginPath();
    dataArray.forEach(function(val, i) {
      const x = padding.left + (chartW / (dataArray.length - 1)) * i;
      const y = padding.top + chartH - (val / maxVal) * chartH;
      if (i === 0) {
        ctx.moveTo(x, y);
      } else {
        ctx.lineTo(x, y);
      }
    });
    ctx.lineTo(padding.left + chartW, height - padding.bottom);
    ctx.lineTo(padding.left, height - padding.bottom);
    ctx.closePath();
    ctx.fillStyle = gradient;
    ctx.fill();

    // Line
    ctx.beginPath();
    dataArray.forEach(function(val, i) {
      const x = padding.left + (chartW / (dataArray.length - 1)) * i;
      const y = padding.top + chartH - (val / maxVal) * chartH;
      if (i === 0) {
        ctx.moveTo(x, y);
      } else {
        ctx.lineTo(x, y);
      }
    });
    ctx.strokeStyle = color;
    ctx.lineWidth = 2.5;
    ctx.stroke();

    // Points
    dataArray.forEach(function(val, i) {
      const x = padding.left + (chartW / (dataArray.length - 1)) * i;
      const y = padding.top + chartH - (val / maxVal) * chartH;
      ctx.beginPath();
      ctx.arc(x, y, 3, 0, Math.PI * 2);
      ctx.fillStyle = color;
      ctx.fill();
      ctx.strokeStyle = '#fff';
      ctx.lineWidth = 2;
      ctx.stroke();
    });
  }

  drawLine(data, '#FF4F87', 'rgba(255, 79, 135, 0.15)');
  drawLine(data2, '#FF7BA6', 'rgba(255, 123, 166, 0.1)');

  // Legend
  const legendX = width - 140;
  const legendY = 12;

  ctx.fillStyle = '#FF4F87';
  ctx.fillRect(legendX, legendY, 12, 3);
  ctx.fillStyle = '#333';
  ctx.font = '11px Poppins, sans-serif';
  ctx.textAlign = 'left';
  ctx.fillText('Pendapatan 2024', legendX + 18, legendY + 4);

  ctx.fillStyle = '#FF7BA6';
  ctx.fillRect(legendX, legendY + 18, 12, 3);
  ctx.fillStyle = '#333';
  ctx.fillText('Pendapatan 2023', legendX + 18, legendY + 22);
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

function drawMiniCharts() {
  document.querySelectorAll('.mc-body').forEach(function(body) {
    const bars = body.querySelectorAll('.bar');
    bars.forEach(function(bar) {
      const h = bar.getAttribute('data-height') || (Math.random() * 40 + 10);
      bar.style.height = h + 'px';
    });
  });
}

/* ---- Notification Dropdown ---- */
function initNotifications() {
  const notifBtn = document.querySelector('.notif-btn');
  if (notifBtn) {
    notifBtn.addEventListener('click', function() {
      alert('Notifikasi akan segera hadir!');
    });
  }
}

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
window.addEventListener('resize', function() {
  const pendapatanCanvas = document.getElementById('chartPendapatan');
  const bookingCanvas = document.getElementById('chartBooking');
  if (pendapatanCanvas) {
    // Debounce
    clearTimeout(window._chartResize);
    window._chartResize = setTimeout(function() {
      drawPendapatanChart(pendapatanCanvas);
    }, 300);
  }
  if (bookingCanvas) {
    clearTimeout(window._chartResize2);
    window._chartResize2 = setTimeout(function() {
      drawBookingChart(bookingCanvas);
    }, 300);
  }
});
