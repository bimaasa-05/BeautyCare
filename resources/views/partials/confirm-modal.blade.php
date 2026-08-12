<style>
    .confirm-premium {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(4px);
        z-index: 1200;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .confirm-premium.show { display: flex; }
    .confirm-premium .cp-box {
        background: #ffffff;
        border-radius: 24px;
        padding: 32px;
        width: 100%;
        max-width: 400px;
        margin: 0 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        animation: cpScaleIn 0.25s ease;
        text-align: center;
    }
    @keyframes cpScaleIn {
        from { transform: scale(0.92); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .confirm-premium .cp-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .confirm-premium .cp-icon i { font-size: 28px; }
    .confirm-premium .cp-title { font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 8px; }
    .confirm-premium .cp-body { font-size: 13px; color: #6B7280; margin: 0 0 24px; line-height: 1.6; }
    .confirm-premium .cp-actions { display: flex; gap: 12px; }
    .confirm-premium .cp-actions button {
        flex: 1;
        padding: 11px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        transition: all 0.2s ease;
    }
    .confirm-premium .cp-actions .cp-cancel {
        border: 1.5px solid #E5E7EB;
        background: #ffffff;
        color: #6B7280;
    }
    .confirm-premium .cp-actions .cp-cancel:hover { background: #F9FAFB; }
    .confirm-premium .cp-actions .cp-yes { border: none; color: #fff; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }
    .confirm-premium .cp-actions .cp-yes:hover { transform: translateY(-1px); }
    .confirm-premium .cp-danger .cp-icon { background: #FEE2E2; }
    .confirm-premium .cp-danger .cp-icon i { color: #DC2626; }
    .confirm-premium .cp-danger .cp-yes { background: linear-gradient(135deg, #DC2626, #EF4444); box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25); }
    .confirm-premium .cp-warning .cp-icon { background: #FEF3C7; }
    .confirm-premium .cp-warning .cp-icon i { color: #D97706; }
    .confirm-premium .cp-warning .cp-yes { background: linear-gradient(135deg, #D97706, #F59E0B); box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25); }
    .confirm-premium .cp-success .cp-icon { background: #D1FAE5; }
    .confirm-premium .cp-success .cp-icon i { color: #059669; }
    .confirm-premium .cp-success .cp-yes { background: linear-gradient(135deg, #059669, #10B981); box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25); }
    .confirm-premium .cp-purple .cp-icon { background: #EDE9FE; }
    .confirm-premium .cp-purple .cp-icon i { color: #7C3AED; }
    .confirm-premium .cp-purple .cp-yes { background: linear-gradient(135deg, #8B5CF6, #A78BFA); box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3); }
    .confirm-premium .cp-brand .cp-icon { background: #FCE7F3; }
    .confirm-premium .cp-brand .cp-icon i { color: #DB2777; }
    .confirm-premium .cp-brand .cp-yes { background: linear-gradient(135deg, #DB2777, #F472B6); box-shadow: 0 4px 12px rgba(219, 39, 119, 0.3); }
</style>
<script>
(function () {
    if (window.__confirmPremium) return;
    window.__confirmPremium = true;

    var modal = null;
    var pendingForm = null;
    var pendingEl = null;

    function build() {
        modal = document.createElement('div');
        modal.className = 'confirm-premium';
        modal.innerHTML =
            '<div class="cp-box cp-danger">' +
                '<div class="cp-icon"><i class="fa-solid fa-circle-question"></i></div>' +
                '<h3 class="cp-title"></h3>' +
                '<p class="cp-body"></p>' +
                '<div class="cp-actions">' +
                    '<button type="button" class="cp-cancel">Batal</button>' +
                    '<button type="button" class="cp-yes"></button>' +
                '</div>' +
            '</div>';
        document.body.appendChild(modal);

        var box = modal.querySelector('.cp-box');
        var iconEl = modal.querySelector('.cp-icon i');
        var titleEl = modal.querySelector('.cp-title');
        var bodyEl = modal.querySelector('.cp-body');
        var yesBtn = modal.querySelector('.cp-yes');
        var cancelBtn = modal.querySelector('.cp-cancel');

        modal.querySelector('.cp-actions .cp-yes').textContent = 'Ya, Lanjutkan';

        function tampilkan(src) {
            titleEl.textContent = src.getAttribute('data-confirm-title') || 'Konfirmasi';
            bodyEl.innerHTML = src.getAttribute('data-confirm-body') || 'Apakah Anda yakin ingin melanjutkan?';
            iconEl.className = 'fa-solid ' + (src.getAttribute('data-confirm-icon') || 'fa-circle-question');
            var tipe = src.getAttribute('data-confirm-type') || 'danger';
            tipe = (tipe === 'danger' || tipe === 'warning') ? 'danger' : 'success';
            ['danger', 'warning', 'success', 'purple', 'brand'].forEach(function (t) {
                box.classList.remove('cp-' + t);
            });
            box.classList.add('cp-' + tipe);
            yesBtn.textContent = src.getAttribute('data-confirm-yes') || 'Ya, Lanjutkan';
            cancelBtn.style.display = '';
            modal.classList.add('show');
        }

        function tutup() {
            modal.classList.remove('show');
            pendingForm = null;
            pendingEl = null;
        }

        document.addEventListener('submit', function (e) {
            var form = e.target && e.target.closest ? e.target.closest('form') : null;
            if (!form) return;
            var src = e.submitter && e.submitter.hasAttribute('data-confirm-title')
                ? e.submitter
                : (form.hasAttribute('data-confirm-title') ? form : null);
            if (!src) return;
            e.preventDefault();
            e.stopPropagation();
            pendingForm = form;
            pendingEl = null;
            tampilkan(src);
        }, true);

        document.addEventListener('click', function (e) {
            if (e.defaultPrevented) return;
            var el = e.target && e.target.closest ? e.target.closest('[data-confirm-title]') : null;
            if (!el || el.tagName === 'FORM' || el.type === 'submit') return;
            if (window.__confirmPremiumAllowClick) {
                window.__confirmPremiumAllowClick = false;
                return;
            }
            e.preventDefault();
            pendingEl = el;
            pendingForm = el.closest('form');
            tampilkan(el);
        }, true);

        cancelBtn.addEventListener('click', tutup);
        modal.addEventListener('click', function (e) { if (e.target === modal) tutup(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') tutup(); });

        yesBtn.addEventListener('click', function () {
            var f = pendingForm, el = pendingEl;
            tutup();
            if (f) { f.submit(); return; }
            if (el) {
                window.__confirmPremiumAllowClick = true;
                el.click();
            }
        });

        window.__confirmPremiumShow = function (opts) {
            opts = opts || {};
            titleEl.textContent = opts.title || 'Perhatian';
            bodyEl.innerHTML = opts.body || '';
            iconEl.className = 'fa-solid ' + (opts.icon || 'fa-circle-exclamation');
            var tipe = opts.type || 'success';
            tipe = (tipe === 'danger' || tipe === 'warning') ? 'danger' : 'success';
            ['danger', 'warning', 'success', 'purple', 'brand'].forEach(function (t) {
                box.classList.remove('cp-' + t);
            });
            box.classList.add('cp-' + tipe);
            yesBtn.textContent = opts.yes || 'Oke';
            cancelBtn.style.display = 'none';
            pendingForm = null;
            pendingEl = null;
            modal.classList.add('show');
        };
    }

    if (document.body) { build(); }
    else { document.addEventListener('DOMContentLoaded', build); }
})();
</script>