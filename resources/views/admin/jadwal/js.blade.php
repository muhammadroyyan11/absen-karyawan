@section('scripts')

    <!-- Daterangepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js"></script>

    <!-- Daterangepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        {{--var jadwalTables = $(document).ready(function() {--}}
        {{--    $('#jadwalData').DataTable({--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        ajax: "{{ route('jadwal.data') }}",--}}
        {{--        columns: [--}}
        {{--            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },--}}
        {{--            { data: 'nama', name: 'nama' },--}}
        {{--            { data: 'tanggal_absen', name: 'tgl_presensi' },--}}
        {{--            { data: 'shift_input', name: 'shifts.name_shift' },--}}
        {{--            { data: 'absen_datang', name: 'jam_in' },--}}
        {{--            { data: 'absen_pulang', name: 'jam_out' },--}}
        {{--            { data: 'aksi', name: 'aksi', orderable: false, searchable: false },--}}
        {{--        ]--}}
        {{--    });--}}
        {{--});--}}

        $(document).ready(function () {
            let start_date = '';
            let end_date = '';

            // $('#filterDivisi').select2({
            //     placeholder: "Pilih Divisi",
            //     allowClear: true
            // });
            //
            // // Contoh: menambahkan event listener filter untuk reload data jadwal



            function loadTable(start = '', end = '') {
                $('#jadwalData').DataTable().destroy();
                var jadwalData = $('#jadwalData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('jadwal.data') }}', // Ganti sesuai route
                        data: function(d) {
                            d.divisi = $('#filterDivisi').val();
                            d.date_range = $('#date_range').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'nama', name: 'nama'},
                        {data: 'departments_name', name: 'departments_name'},
                        {data: 'tanggal_absen', name: 'tgl_presensi'},
                        {data: 'shift_input', name: 'shifts.name_shift'},
                        {data: 'absen_datang', name: 'jam_in'},
                        {data: 'absen_pulang', name: 'jam_out'},
                        {data: 'aksi', name: 'aksi', orderable: false, searchable: false},
                    ]
                });
            }

            {{--$(document).on('click', '#btn-detail', function() {--}}
            {{--    var date = $(this).data('date');--}}

            {{--    $.ajax({--}}
            {{--        url: '{{ route("") }}',--}}
            {{--        method: 'GET',--}}
            {{--        data: { date: date },--}}
            {{--        success: function(response) {--}}
            {{--            $('#detailPresensiContent').html(response.html);--}}
            {{--            $('#modalDetailPresensi').modal('show');--}}

            {{--            setTimeout(() => {--}}
            {{--                response.presensi.forEach(item => {--}}
            {{--                    initLeafletMap('mapIn' + item.id, item.location_in);--}}
            {{--                    initLeafletMap('mapOut' + item.id, item.location_out);--}}
            {{--                });--}}
            {{--            }, 300); // beri sedikit delay agar div-nya muncul dulu--}}
            {{--        },--}}
            {{--        error: function() {--}}
            {{--            alert('Gagal memuat data.');--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            $(document).on('click', '#btn-detail-presensi', function() {
                const user_id = $(this).data('user-id');
                const date = $(this).data('date');

                $.ajax({
                    url: '{{ route("jadwal.presensi.detail") }}',
                    type: 'GET',
                    data: { user_id, date },
                    success: function(response) {
                        $('#detailPresensiContent').html(response.html);
                        $('#modalDetailPresensi').modal('show');

                        setTimeout(() => {
                            response.presensi.forEach(item => {
                                initLeafletMap('mapIn' + item.id, item.location_in);
                                initLeafletMap('mapOut' + item.id, item.location_out);
                            });
                        }, 300);
                    }
                });
            });

            function initLeafletMap(elementId, coords) {
                if (!coords) return;

                const [lat, lng] = coords.split(',').map(parseFloat);
                const map = L.map(elementId).setView([lat, lng], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);

                L.marker([lat, lng]).addTo(map);
            }


            $('#date_range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Reset'
                },
                ranges: {
                    'Hari Ini': [moment(), moment()],
                    'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                    'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    'Bulan Kemarin': [
                        moment().subtract(1, 'month').startOf('month'),
                        moment().subtract(1, 'month').endOf('month')
                    ]
                }
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                start_date = picker.startDate.format('YYYY-MM-DD');
                end_date = picker.endDate.format('YYYY-MM-DD');
                $(this).val(start_date + ' - ' + end_date);
                loadTable(start_date, end_date);
            });

            $('#filterDivisi').on('change', function() {
                // reload / refresh datatable jadwalData, contoh:
                $('#jadwalData').DataTable().ajax.reload();
            });

            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                start_date = '';
                end_date = '';
                loadTable();
            });

            // Load default
            loadTable();
        });

        $(document).ready(function () {
            $('#openTemplateModal').on('click', function () {
                $('#generateTemplateModal').modal('show');
            });

            $('#downloadTemplateBtn').on('click', function () {
                let week = $('#weekSelect').val();

                if (!week) {
                    alert('Silakan pilih minggu terlebih dahulu.');
                    return;
                }

                let downloadUrl = `/jadwal/export-template?week=${week}`;

                window.open(downloadUrl, '_blank');

                $('#generateTemplateModal').modal('hide');
            });
        });


        document.getElementById('openImportModal').addEventListener('click', function () {
            $('#importJadwalModal').modal('show');
        });

        document.getElementById('importJadwalForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = document.getElementById('importJadwalForm');
            const formData = new FormData(form);

            fetch("{{ route('jadwal.import') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    $('#importJadwalModal').modal('hide');
                    alert('Jadwal berhasil diimport!');
                    // Reload table jika perlu
                    $('#jadwalData').DataTable().ajax.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat import!');
                });
        });
    </script>

@endsection
