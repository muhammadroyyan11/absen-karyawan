<div class="modal fade" id="generateTemplateModal" tabindex="-1" role="dialog" aria-labelledby="generateTemplateLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Generate Template Jadwal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="weekSelect">Pilih Minggu:</label>
                <select id="weekSelect" class="form-control">
                    <option value="">-- Pilih Minggu --</option>
                    <option value="1">Minggu ke-1</option>
                    <option value="2">Minggu ke-2</option>
                    <option value="3">Minggu ke-3</option>
                    <option value="4">Minggu ke-4</option>
                    <option value="5">Minggu ke-5</option>
                </select>
            </div>
            <div class="modal-footer">
                <button id="downloadTemplateBtn" class="btn btn-success">Download Template</button>
                <button class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>


{{--import jadwal cuy --}}
<div class="modal fade" id="importJadwalModal" tabindex="-1" role="dialog" aria-labelledby="importJadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="importJadwalForm">
                <div class="modal-header">
                    <h5 class="modal-title">Import Jadwal Mingguan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="week">Pilih Minggu:</label>
                        <select name="week" id="week" class="form-control" required>
                            <option value="1">Minggu 1</option>
                            <option value="2">Minggu 2</option>
                            <option value="3">Minggu 3</option>
                            <option value="4">Minggu 4</option>
                            <option value="5">Minggu 5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file">File Excel:</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
