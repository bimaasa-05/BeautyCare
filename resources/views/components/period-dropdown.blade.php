@props(['id', 'default' => '', 'title' => 'Periode Grafik', 'options' => []])
<div style="position:relative;" id="{{ $id }}Wrap">
    <button type="button" class="period-trigger" id="{{ $id }}Trigger">
        <i class="fa-solid fa-calendar-days"></i>
        <span id="{{ $id }}Label">{{ $options[$default] ?? array_values($options)[0] ?? 'Pilih' }}</span>
        <i class="fa-solid fa-chevron-down period-arrow"></i>
    </button>
    <div class="period-popup" id="{{ $id }}Popup">
        <div class="pp-header">
            <span class="pp-icon"><i class="fa-solid fa-chart-line"></i></span>
            <h4>{{ $title }}</h4>
        </div>
        <div id="{{ $id }}Options" class="pp-options"></div>
        <div class="pp-footer">
            <button type="button" class="pp-today" id="{{ $id }}Reset"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
            <button type="button" class="pp-oke" id="{{ $id }}Oke"><i class="fa-solid fa-check"></i> Oke</button>
        </div>
    </div>
</div>
