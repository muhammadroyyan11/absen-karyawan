@section('scripts')
    <script>
        $(document).ready(function () {

            var table = $('#shift-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('shift.data') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {data: 'name_shift', name: 'name_shift'},
                    {data: 'type_name', name: 'type_name'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.btn-detail-shifts', function () {
                var shiftId = $(this).data('shift-id');
                console.log('Shift ID:', shiftId);

                $.ajax({
                    url: "{{ route('shift.detail') }}",
                    type: 'GET',
                    data: {
                        shift_id: shiftId
                    },
                    success: function (response) {
                        // console.log(response);
                        window.location.href = '/shift/detail/' + shiftId;
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $(document).ready(function() {
                function saveShift(row) {
                    const shiftId = $('#shift_id').val();

                    console.log(shiftId)
                    const day = row.data('day');
                    const timeStart = row.find('.time-start').val();
                    const timeEnd = row.find('.time-end').val();

                    $.ajax({
                        url: '/shifts/days-save',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            shift_id: shiftId,
                            name_day_shift: day,
                            time_start: timeStart,
                            time_end: timeEnd,
                        },
                        success: function(response) {
                            if (response.shift_id) {
                                row.attr('data-shift-id', response.shift_id);
                                row.find('.btn-remove').removeClass('btn-secondary').addClass('btn-danger').prop('disabled', false);
                            }
                            alert('Data shift untuk ' + day + ' berhasil disimpan.');
                        },
                        error: function(xhr) {
                            alert('Gagal menyimpan data shift untuk ' + day);
                        }
                    });
                }

                $('.time-start, .time-end').on('change', function() {
                    const row = $(this).closest('.days-shifts');
                    saveShift(row);
                });

                $('.btn-remove').on('click', function() {
                    const row = $(this).closest('.days-shifts');
                    const shiftId = row.data('shift-id');

                    if (!shiftId) return;

                    if (confirm('Yakin ingin menghapus shift ini?')) {
                        $.ajax({
                            url: '/shifts/ajax-delete',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                shift_id: shiftId
                            },
                            success: function(response) {
                                alert('Shift berhasil dihapus.');
                                row.find('.time-start, .time-end').val('');
                                row.attr('data-shift-id', '');
                                row.find('.btn-remove').removeClass('btn-danger').addClass('btn-secondary').prop('disabled', true);
                            },
                            error: function(xhr) {
                                alert('Gagal menghapus shift.');
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.edit', function () {
                var id = $(this).data('id');
                $.get('/cuti/' + id + '/edit', function (data) {
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#leader_id').val(data.leader_id);
                    $('#departmentModal').modal('show');
                });
            });

            function updateSelectedUserList() {
                let selected = $('#user_ids').select2('data');
                let list = $('#selected-users-list');
                list.empty(); // Clear previous items

                if (selected.length === 0) {
                    list.append('<li class="list-group-item text-muted">Tidak ada user dipilih</li>');
                } else {
                    selected.forEach(user => {
                        list.append(`<li class="list-group-item">${user.text}</li>`);
                    });
                }
            }

            // Trigger update when selection changes
            $('#user_ids').on('change', updateSelectedUserList);

            // Reset list when modal opens
            $('#setUsersModal').on('shown.bs.modal', function () {
                updateSelectedUserList();
            });

            $('#form').submit(function (e) {
                e.preventDefault();
                var id = $('#id').val();
                var url = id ? '/cuti/' + id + '/update' : '/cuti/store';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $('#form').serialize(),
                    success: function () {
                        $('#departmentModal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON.message);
                    }
                });
            });

            $(document).on('click', '.delete', function () {
                if (confirm('Yakin hapus?')) {
                    $.ajax({
                        url: '/cuti/' + $(this).data('id') + '/delete',
                        type: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function () {
                            table.ajax.reload();
                        }
                    });
                }
            });

            $(document).on('click', '.set-users', function () {
                let deptId = $(this).data('id');
                let deptName = $(this).data('name');

                $('#modal-department-id').val(deptId);
                $('#modal-department-name').text(deptName);
                $('#user_ids').val(null).trigger('change'); // Reset select

                $('#setUsersModal').modal('show');
            });


            $('#set-users-form').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route("cuti.assignUsers") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (res) {
                        $('#setUsersModal').modal('hide');
                        $('#cuti-table').DataTable().ajax.reload();
                        alert(res.message);
                    },
                    error: function (err) {
                        alert('Error: ' + err.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endsection
