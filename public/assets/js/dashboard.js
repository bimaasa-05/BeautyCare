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

  const donutCanvas = document.getElementById('chartBookingDonut');
  if (donutCanvas) {
    drawDonutChart(donutCanvas);
  }
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

  var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
  var data = [0,0,0,0,0,0,0,0,0,0,0,0];
  try {
    labels = JSON.parse(canvas.getAttribute('data-labels')) || labels;
    data = JSON.parse(canvas.getAttribute('data-revenue')) || data;
  } catch(e) {}
  const data2 = data.map(function(v) { return Math.round(v * 0.7); });
  const maxVal = Math.max(...data, ...data2) * 1.2;

  function getPoints(arr) {
    return arr.map(function(val, i) {
      return {
        x: padding.left + (chartW / (arr.length - 1)) * i,
        y: padding.top + chartH - (val / maxVal) * chartH,
        value: val,
        index: i
      };
    });
  }
  var points1 = getPoints(data);
  var points2 = getPoints(data2);

  var currentYear = new Date().getFullYear();
  var prevYear = currentYear - 1;

  function fmtRp(amount) {
    if (amount >= 1000000000) return 'Rp ' + (amount / 1000000000).toFixed(1) + ' M';
    if (amount >= 1000000) return 'Rp ' + (amount / 1000000).toFixed(1) + ' jt';
    return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  function drawAll(hoverIdx) {
    ctx.clearRect(0, 0, width, height);

    ctx.strokeStyle = '#ECECEC';
    ctx.lineWidth = 1;
    for (let i = 0; i <= 5; i++) {
      const y = padding.top + chartH - (chartH / 5) * i;
      ctx.beginPath();
      ctx.moveTo(padding.left, y);
      ctx.lineTo(width - padding.right, y);
      ctx.stroke();
      ctx.fillStyle = '#999';
      ctx.font = '11px Poppins, sans-serif';
      ctx.textAlign = 'right';
      ctx.fillText(Math.round(maxVal / 5 * i).toString(), padding.left - 10, y + 4);
    }

    ctx.fillStyle = '#999';
    ctx.font = '11px Poppins, sans-serif';
    ctx.textAlign = 'center';
    labels.forEach(function(label, i) {
      const x = padding.left + (chartW / (labels.length - 1)) * i;
      ctx.fillText(label, x, height - padding.bottom + 18);
    });

    function drawLine(points, color, gradientColor, isPrimary) {
      var values = points.map(function(p) { return p.value; });

      var gradient = ctx.createLinearGradient(0, padding.top, 0, height - padding.bottom);
      gradient.addColorStop(0, gradientColor);
      gradient.addColorStop(1, 'rgba(255, 79, 135, 0)');

      if (hoverIdx < 0 || !isPrimary) {
        ctx.beginPath();
        points.forEach(function(p, i) {
          if (i === 0) ctx.moveTo(p.x, p.y);
          else ctx.lineTo(p.x, p.y);
        });
        ctx.lineTo(points[points.length - 1].x, height - padding.bottom);
        ctx.lineTo(points[0].x, height - padding.bottom);
        ctx.closePath();
        ctx.fillStyle = gradient;
        ctx.fill();
      }

      ctx.beginPath();
      points.forEach(function(p, i) {
        if (i === 0) ctx.moveTo(p.x, p.y);
        else ctx.lineTo(p.x, p.y);
      });
      ctx.strokeStyle = color;
      ctx.lineWidth = 2.5;
      ctx.globalAlpha = hoverIdx >= 0 ? (isPrimary ? 1 : 0.3) : 1;
      ctx.stroke();
      ctx.globalAlpha = 1;

      points.forEach(function(p) {
        var isHover = (hoverIdx === p.index);
        ctx.beginPath();
        ctx.arc(p.x, p.y, isHover ? 7 : 3, 0, Math.PI * 2);
        ctx.fillStyle = isHover ? '#fff' : color;
        ctx.fill();
        ctx.strokeStyle = isHover ? color : '#fff';
        ctx.lineWidth = isHover ? 3 : 2;
        ctx.stroke();
      });
    }

    drawLine(points2, '#FF7BA6', 'rgba(255, 123, 166, 0.1)', false);
    drawLine(points1, '#FF4F87', 'rgba(255, 79, 135, 0.15)', true);

    var legendX = width - 140;
    var legendY = 12;
    ctx.fillStyle = '#FF4F87';
    ctx.fillRect(legendX, legendY, 12, 3);
    ctx.fillStyle = '#333';
    ctx.font = '11px Poppins, sans-serif';
    ctx.textAlign = 'left';
    ctx.fillText('Pendapatan ' + currentYear, legendX + 18, legendY + 4);

    ctx.fillStyle = '#FF7BA6';
    ctx.fillRect(legendX, legendY + 18, 12, 3);
    ctx.fillStyle = '#333';
    ctx.fillText('Pendapatan ' + prevYear, legendX + 18, legendY + 22);
  }

  drawAll(-1);

  var tooltip = document.getElementById('pendapatanTooltip');
  if (!tooltip) {
    tooltip = document.createElement('div');
    tooltip.id = 'pendapatanTooltip';
    tooltip.style.cssText = 'position:fixed;background:#333;color:#fff;padding:8px 12px;border-radius:8px;font-size:12px;font-family:Poppins,sans-serif;line-height:1.6;pointer-events:none;z-index:999;opacity:0;transition:opacity 0.15s;max-width:220px;';
    document.body.appendChild(tooltip);
  }

  canvas.addEventListener('mousemove', function(e) {
    var br = canvas.getBoundingClientRect();
    var mx = e.clientX - br.left;
    var my = e.clientY - br.top;

    var minDist = 18;
    var nearest = -1;
    points1.forEach(function(p, i) {
      var dx = mx - p.x;
      var dy = my - p.y;
      var dist = Math.sqrt(dx*dx + dy*dy);
      if (dist < minDist) {
        minDist = dist;
        nearest = i;
      }
    });

    if (nearest >= 0) {
      drawAll(nearest);
      canvas.style.cursor = 'pointer';
      tooltip.innerHTML =
        '<div style="font-weight:600;margin-bottom:4px;">' + labels[nearest] + ' ' + currentYear + '</div>' +
        '<div style="color:#FF4F87;">' + fmtRp(data[nearest]) + '</div>' +
        '<div style="color:#FF7BA6;font-size:11px;margin-top:2px;">' + fmtRp(data2[nearest]) + ' (' + prevYear + ')</div>';
      tooltip.style.opacity = '1';
      var tx = e.clientX + 14;
      var ty = e.clientY - 10;
      if (tx + 230 > window.innerWidth) tx = e.clientX - 230;
      if (ty < 4) ty = 4;
      tooltip.style.left = tx + 'px';
      tooltip.style.top = ty + 'px';
    } else {
      drawAll(-1);
      tooltip.style.opacity = '0';
      canvas.style.cursor = 'default';
    }
  });

  canvas.addEventListener('mouseleave', function() {
    drawAll(-1);
    tooltip.style.opacity = '0';
    canvas.style.cursor = 'default';
  });
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

function drawDonutChart(canvas) {
  var values = [];
  var labels = [];
  try {
    values = JSON.parse(canvas.getAttribute('data-values')) || [];
    labels = JSON.parse(canvas.getAttribute('data-labels')) || [];
  } catch(e) {}

  var total = values.reduce(function(a,b) { return a+b; }, 0);
  if (total === 0) {
    var p = canvas.parentNode;
    if (p) p.innerHTML = '<span style="font-size:12px;color:#999;">Tidak ada data</span>';
    return;
  }

  var colorPalette = [
    '#FF4F87','#FF7BA6','#FFB3CC','#E8A0BF','#C9A0DC',
    '#7EC8E3','#82D4A8','#F4C770','#F09B7A','#A89CC8',
    '#7BC8A4','#D494B0','#80B8D4','#E5A878','#B8A0C8'
  ];

  var dpr = window.devicePixelRatio || 1;
  var rect = canvas.getBoundingClientRect();
  var w = rect.width;
  var h = rect.height;
  canvas.width = w * dpr;
  canvas.height = h * dpr;
  var ctx = canvas.getContext('2d');
  ctx.scale(dpr, dpr);

  var cx = w / 2;
  var cy = h / 2;
  var outerR = Math.min(cx, cy) - 6;
  var innerR = outerR * 0.55;

  var segments = [];
  var startAngle = -Math.PI / 2;

  for (var i = 0; i < values.length; i++) {
    if (values[i] === 0) { segments.push(null); continue; }
    var sliceAngle = (values[i] / total) * Math.PI * 2;
    var endAngle = startAngle + sliceAngle;
    segments.push({ start: startAngle, end: endAngle, index: i });
    startAngle = endAngle;
  }

  function draw(hoverIndex) {
    ctx.clearRect(0, 0, w, h);
    for (var i = 0; i < segments.length; i++) {
      if (!segments[i]) continue;
      var seg = segments[i];
      var isHover = (hoverIndex === seg.index);
      var r = isHover ? outerR + 4 : outerR;

      ctx.beginPath();
      ctx.arc(cx, cy, r, seg.start, seg.end);
      ctx.arc(cx, cy, innerR, seg.end, seg.start, true);
      ctx.closePath();
      ctx.fillStyle = colorPalette[seg.index % colorPalette.length];
      ctx.fill();

    }

    ctx.fillStyle = '#333';
    ctx.font = 'bold 16px Poppins, sans-serif';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(total, cx, cy - 6);
    ctx.font = '9px Poppins, sans-serif';
    ctx.fillStyle = '#999';
    ctx.fillText('Booking', cx, cy + 10);
  }

  draw(-1);

  var tooltip = document.getElementById('donutTooltip');
  if (!tooltip) {
    tooltip = document.createElement('div');
    tooltip.id = 'donutTooltip';
    tooltip.style.cssText = 'position:fixed;background:#333;color:#fff;padding:8px 12px;border-radius:8px;font-size:12px;font-family:Poppins,sans-serif;line-height:1.6;pointer-events:none;z-index:999;opacity:0;transition:opacity 0.15s;max-width:220px;';
    document.body.appendChild(tooltip);
  }

  canvas.addEventListener('mousemove', function(e) {
    var br = canvas.getBoundingClientRect();
    var mx = e.clientX - br.left;
    var my = e.clientY - br.top;

    var dx = mx - cx;
    var dy = my - cy;
    var dist = Math.sqrt(dx*dx + dy*dy);

    if (dist < innerR || dist > outerR + 4) {
      tooltip.style.opacity = '0';
      draw(-1);
      canvas.style.cursor = 'default';
      return;
    }

    var angle = Math.atan2(dy, dx);
    if (angle < 0) angle += Math.PI * 2;

    for (var i = 0; i < segments.length; i++) {
      if (!segments[i]) continue;
      var seg = segments[i];
      var start = ((seg.start % (Math.PI * 2)) + (Math.PI * 2)) % (Math.PI * 2);
      var end = ((seg.end % (Math.PI * 2)) + (Math.PI * 2)) % (Math.PI * 2);

      var hit = false;
      if (start > end) {
        if (angle >= start || angle <= end) hit = true;
      } else {
        if (angle >= start && angle <= end) hit = true;
      }

      if (hit) {
        draw(seg.index);
        canvas.style.cursor = 'pointer';

        var html = '<div style="font-weight:600;margin-bottom:4px;">' + labels[seg.index] + '</div>' +
          '<div>' + values[seg.index] + ' booking (' + Math.round((values[seg.index] / total) * 100) + '%)</div>';
        tooltip.innerHTML = html;
        tooltip.style.opacity = '1';

        var tx = e.clientX + 14;
        var ty = e.clientY - 10;
        if (tx + 230 > window.innerWidth) tx = e.clientX - 230;
        if (ty < 4) ty = 4;
        tooltip.style.left = tx + 'px';
        tooltip.style.top = ty + 'px';
        return;
      }
    }
    tooltip.style.opacity = '0';
    draw(-1);
    canvas.style.cursor = 'default';
  });

  canvas.addEventListener('mouseleave', function() {
    tooltip.style.opacity = '0';
    draw(-1);
    canvas.style.cursor = 'default';
  });
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
