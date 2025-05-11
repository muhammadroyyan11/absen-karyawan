<div class="modal fade" id="departmentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <form id="form">
                @csrf
                <div class="modal-body">

                    <input type="hidden" name="id" id="id">
                    <div class="modal-content">

                        <div class="form-group">
                            <label>Nama Department</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="Input Department Name" required>
                        </div>
                        <div class="form-group">
                            <label>Leader</label>
                            <select class="form-control select2" name="leader_id" id="leader_id" style="width: 100%;">
                                <option value="">-- None --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>


<div class="modal fade" id="setUsersModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <form id="set-users-form">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="department_id" id="modal-department-id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih User</label>
                            <select class="form-control select2" multiple="multiple" name="user_ids[]" id="user_ids"  data-placeholder="Select Staff" style="width: 100%;">
                                @foreach ($user_dept as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Users Selected:</label>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                </tr>
                                </thead>
                                <tbody id="selected-users-table-body">
                                <tr><td colspan="2" class="text-muted">Belum ada user dipilih</td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
