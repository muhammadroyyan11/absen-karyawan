@section('scripts')
    <script>
        var jadwalTables = $(document).ready(function() {
            $('#jadwalData').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('jadwal.data') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama', name: 'nama' },
                    { data: 'tanggal_absen', name: 'tgl_presensi' },
                    { data: 'shift_input', name: 'shifts.name_shift' },
                    { data: 'absen_datang', name: 'jam_in' },
                    { data: 'absen_pulang', name: 'jam_out' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
                ]
            });
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
