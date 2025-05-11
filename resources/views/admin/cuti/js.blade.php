@section('scripts')
    <script>
        $(document).ready(function () {

            var table = $('#cuti-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('cuti.data') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {data: 'name', name: 'name'},
                    {data: 'leader', name: 'leader.name'},
                    { data: 'users', name: 'users' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#add-button').on('click', function () {
                $('#form')[0].reset();
                $('#id').val('');
                $('#modalLabel').text('Tambah Department');
                $('#departmentModal').modal('show');
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
