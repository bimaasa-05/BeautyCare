<style>
    .pw-meter {
        margin-top: 8px;
        display: none;
    }

    .pw-meter .pw-bar {
        display: flex;
        gap: 4px;
        height: 6px;
    }

    .pw-meter .pw-bar span {
        flex: 1;
        border-radius: 4px;
        background: #e5e7eb;
        transition: background-color .2s ease;
    }

    .pw-meter .pw-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 4px;
        font-size: 11px;
        font-weight: 600;
    }

    .pw-meter .pw-hint {
        color: #ef4444;
    }
</style>

<script>
    window.initPasswordStrength = function (input, meterId) {
        const meter = document.getElementById(meterId);
        if (!meter || !input) return;
        const bar = meter.querySelector('.pw-bar');
        const label = meter.querySelector('.pw-label');
        const hint = meter.querySelector('.pw-hint');
        const levels = [
            { color: '#EF4444', text: 'Lemah' },
            { color: '#F97316', text: 'Sedang' },
            { color: '#F59E0B', text: 'Kuat' },
            { color: '#22C55E', text: 'Sangat Kuat' },
        ];

        const update = function () {
            const v = input.value;
            if (!v) {
                meter.style.display = 'none';
                return;
            }
            meter.style.display = 'block';
            let score = 0;
            if (v.length >= 8) score++;
            if (/[a-z]/.test(v)) score++;
            if (/[A-Z]/.test(v)) score++;
            if (/[0-9]/.test(v)) score++;
            if (/[^a-zA-Z0-9]/.test(v)) score++;
            const seg = v.length < 6 ? 1 : Math.max(1, Math.min(4, score));
            const lvl = levels[seg - 1];
            Array.from(bar.children).forEach(function (s, i) {
                s.style.backgroundColor = i < seg ? lvl.color : '#e5e7eb';
            });
            label.textContent = lvl.text;
            label.style.color = lvl.color;
            hint.textContent = v.length < 6 ? 'Minimal 6 karakter' : '';
        };

        input.addEventListener('input', update);
        update();
    };
</script>
