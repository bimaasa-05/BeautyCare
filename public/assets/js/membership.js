/* ============================================
   BeautyCare - Halaman Admin Membership
   ============================================ */

// Tanggal saat ini di header
const now = new Date();
const options = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
};
const dateEl = document.getElementById('currentDate');
if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);

// Animasi progress bar distribusi paket
document.querySelectorAll('.pg-fill').forEach(function(fill) {
    var width = parseInt(fill.getAttribute('data-width')) || 0;
    setTimeout(function() { fill.style.width = width + '%'; }, 200);
});


