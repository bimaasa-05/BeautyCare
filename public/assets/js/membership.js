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

// Filter tabel berdasarkan tingkat
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const rows = document.querySelectorAll('#memberTableBody tr');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const tingkat = this.dataset.filter;
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            rows.forEach(row => {
                if (tingkat === 'all' || row.dataset.tingkat === tingkat) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Pencarian paket berdasarkan nama
    const searchInput = document.getElementById('searchMember');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            rows.forEach(function(row) {
                const nm = row.querySelector('[data-label="Nama Paket"]')?.textContent?.toLowerCase() || '';
                if (nm.includes(q)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
