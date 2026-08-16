{{--
    Partial polling realtime status booking.
    Penggunaan:
        @include('partials.realtime-booking', ['rtScope' => 'umum'])
    Scope: 'umum' (admin/kasir, semua booking) | 'beautycian' | 'pelanggan'
    Elemen status ditandai: data-rt-booking="ID" data-rt-status="status"
    Kolom kanban ditandai: data-rt-column="dikonfirmasi|diproses|selesai"
    Jika ada perubahan status/komposisi kolom -> halaman di-refresh otomatis.
--}}
<script>
    function initRealtimeBooking(options) {
        var opts = options || {};
        var url = opts.url || '{{ route('realtime.booking-status') }}';
        var scope = opts.scope || 'umum';
        var interval = opts.interval || 7000;
        var kolom = ['dikonfirmasi', 'diproses', 'selesai'];

        function kumpulkanIds() {
            var ids = [];
            document.querySelectorAll('[data-rt-booking]').forEach(function (el) {
                var id = el.getAttribute('data-rt-booking');
                if (id && ids.indexOf(id) === -1) ids.push(id);
            });
            return ids;
        }

        function komposisiKolom() {
            var hasil = {};
            document.querySelectorAll('[data-rt-column]').forEach(function (col) {
                var ids = [];
                col.querySelectorAll('[data-rt-booking]').forEach(function (el) {
                    ids.push(el.getAttribute('data-rt-booking'));
                });
                hasil[col.getAttribute('data-rt-column')] = ids;
            });
            return hasil;
        }

        function poll() {
            var ids = kumpulkanIds();
            if (!ids.length) return;

            fetch(url + '?ids=' + ids.join(',') + '&scope=' + encodeURIComponent(scope), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                var berubah = false;

                ids.forEach(function (id) {
                    var info = (data.items || {})[id];
                    if (!info) return;
                    document.querySelectorAll('[data-rt-booking="' + id + '"]').forEach(function (el) {
                        var statusLama = el.getAttribute('data-rt-status');
                        if (statusLama !== null && statusLama !== info.status) {
                            el.setAttribute('data-rt-status', info.status);
                            berubah = true;
                        }
                    });
                });

                if (data.columns && document.querySelector('[data-rt-column]')) {
                    var sekarang = komposisiKolom();
                    kolom.forEach(function (key) {
                        var a = (sekarang[key] || []).slice().sort().join(',');
                        var b = ((data.columns[key] || []).slice().sort()).join(',');
                        if (a !== b) berubah = true;
                    });
                }

                if (berubah) location.reload();
            })
            .catch(function () {});
        }

        poll();
        setInterval(poll, interval);
    }

    initRealtimeBooking({ scope: '{{ $rtScope ?? 'umum' }}' });
</script>