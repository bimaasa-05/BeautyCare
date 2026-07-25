/**
 * BeautyCare - Beautycian Dashboard
 */
document.addEventListener('DOMContentLoaded', function () {
    // Set current date
    var now = new Date();
    var options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    var dateEl = document.getElementById('currentDate');
    if (dateEl) {
        dateEl.textContent = now.toLocaleDateString('id-ID', options);
    }
});