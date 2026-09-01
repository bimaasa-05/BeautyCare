/**
 * BeautyCare Unified Dropdown Factory
 * Source: beautycian/dashboard.blade.php:521-615 + admin/dashboard.blade.php:1166-1299
 * Usage: initPeriodDropdown({wrapId,triggerId,popupId,optionsId,labelId,resetId,okeId,defaultValue,periodConfig,onChange})
 */
function initPeriodDropdown(cfg) {
    const wrap = document.getElementById(cfg.wrapId);
    const trigger = document.getElementById(cfg.triggerId);
    const popup = document.getElementById(cfg.popupId);
    const optionsEl = document.getElementById(cfg.optionsId);
    const label = document.getElementById(cfg.labelId);
    const resetBtn = document.getElementById(cfg.resetId);
    const okeBtn = document.getElementById(cfg.okeId);
    if (!wrap || !trigger || !popup || !optionsEl) return;

    const validKeys = cfg.periodConfig.map(c => c.key);
    let value = validKeys.includes(cfg.defaultValue) ? cfg.defaultValue : cfg.periodConfig[0].key;
    const initCfg = cfg.periodConfig.find(c => c.key === value);
    if (initCfg && label) label.textContent = initCfg.title;

    function build() {
        optionsEl.innerHTML = '';
        cfg.periodConfig.forEach(function(c) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'pp-option' + (c.key === value ? ' selected' : '');
            btn.setAttribute('data-key', c.key);
            btn.innerHTML = '<span class="po-title">' + c.title + ' <i class="fa-solid fa-check"></i></span><span class="po-sub">' + c.sub + '</span>';
            btn.addEventListener('click', function(e){
                e.stopPropagation();
                optionsEl.querySelectorAll('.pp-option').forEach(o => o.classList.remove('selected'));
                btn.classList.add('selected');
                value = btn.getAttribute('data-key');
            });
            optionsEl.appendChild(btn);
        });
    }
    function position(){
        if (window.matchMedia('(max-width: 480px)').matches) { popup.classList.remove('open-up'); return; }
        const rect = trigger.getBoundingClientRect();
        const spaceBelow = window.innerHeight - rect.bottom;
        const h = popup.offsetHeight;
        if (spaceBelow < h + 12 && rect.top > h + 12) popup.classList.add('open-up');
        else popup.classList.remove('open-up');
    }
    function open(){ build(); popup.classList.add('open'); trigger.classList.add('open'); position(); }
    function close(){ popup.classList.remove('open'); trigger.classList.remove('open'); }
    function apply(){
        const found = cfg.periodConfig.find(c => c.key === value);
        if (found && label) label.textContent = found.title;
        if (typeof cfg.onChange === 'function') cfg.onChange(value);
        close();
    }
    trigger.addEventListener('click', function(e){
        e.stopPropagation();
        if (popup.classList.contains('open')) close(); else open();
    });
    if (okeBtn) okeBtn.addEventListener('click', function(e){ e.stopPropagation(); apply(); });
    if (resetBtn) resetBtn.addEventListener('click', function(e){
        e.stopPropagation();
        value = cfg.periodConfig[0].key;
        build();
        apply();
    });
    document.addEventListener('click', function(e){
        if (wrap && !wrap.contains(e.target)) close();
    });
    // expose getter
    return { getValue: () => value, setValue: (v) => { if(validKeys.includes(v)){ value=v; const f=cfg.periodConfig.find(c=>c.key===v); if(f&&label) label.textContent=f.title; } } };
}
window.initPeriodDropdown = initPeriodDropdown;
