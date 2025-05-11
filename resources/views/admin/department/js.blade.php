@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#departments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('departments.data') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    { data: 'name', name: 'name' },
                    { data: 'leader', name: 'leader.name' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).ready(function () {
                $('.select2').select2({
                    dropdownParent: $('#departmentModal')
                });
            });

            $('#add-button').on('click', function () {
                $('#form')[0].reset();
                $('#id').val('');
                $('#modalLabel').text('Tambah Department');
                $('#departmentModal').modal('show');
            });

            $(document).on('click', '.edit', function () {
                var id = $(this).data('id');
                $.get('/departments/' + id + '/edit', function (data) {
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#leader_id').val(data.leader_id);
                    $('#departmentModal').modal('show');
                });
            });


            $('#form').submit(function (e) {
                e.preventDefault();
                var id = $('#id').val();
                var url = id ? '/departments/' + id + '/update' : '/departments/store';

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
                        url: '/departments/' + $(this).data('id') + '/delete',
                        type: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function () {
                            table.ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
