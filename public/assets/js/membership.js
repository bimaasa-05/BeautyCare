/* ============================================
   BeautyCare - Halaman Admin Membership
   ============================================ */

// Animasi progress bar distribusi paket
document.querySelectorAll('.pg-fill').forEach(function(fill) {
    var width = parseInt(fill.getAttribute('data-width')) || 0;
    setTimeout(function() { fill.style.width = width + '%'; }, 200);
});


