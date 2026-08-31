{{--
    Ringkasan rating terpadu (kotak skor + bintang + jumlah + distribusi 5->1).
    Dipakai di landing & halaman pelanggan agar tampilannya sama persis.
    @param array $ringkasan ['rata' => float, 'jumlah' => int, 'distribusi' => [5=>n,4=>n,3=>n,2=>n,1=>n]]
--}}
@php
    $rata = round((float) ($ringkasan['rata'] ?? 0), 1);
    $jumlah = (int) ($ringkasan['jumlah'] ?? 0);
    $distribusi = $ringkasan['distribusi'] ?? [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
@endphp
<div class="rs-box">
    <div class="rs-score">{{ number_format($rata, 1, ',', '.') }}</div>
    <div class="rs-stars">{{ str_repeat('★', (int) round($rata)) }}{{ str_repeat('☆', 5 - (int) round($rata)) }}</div>
    <div class="rs-count">{{ $jumlah }} ulasan</div>
    @if ($jumlah > 0)
        <div class="rs-dist">
            @foreach ($distribusi as $bintang => $total)
                @php
                    $persen = $jumlah > 0 ? round((int) $total / $jumlah * 100) : 0;
                @endphp
                <div class="rs-dist-item">
                    <span>{{ $bintang }} ★</span>
                    <div class="rs-dist-bar"><div class="rs-dist-fill" style="width:{{ $persen }}%"></div></div>
                    <span>{{ $total }}</span>
                </div>
            @endforeach
        </div>
    @endif
</div>