@if($history->isEmpty())
    <div class="alert alert-outline-warning">
        <p>Data Tidak Di Temukan</p>
    </div>
@endif

@foreach($history as $d)
    <h3>History</h3>
    <ul class="listview image-listview">
        <li>
            <div class="item">
                <div class="icon-box bg-primary">
                    <ion-icon name="finger-print-outline"></ion-icon>
                </div>
                <div class="in">
                    <div>{{ \Carbon\Carbon::parse($d->tgl_presensi)->locale('id')->translatedFormat('d F Y') }}</div>
                    <div>
                        <div>
                            <span class="badge badge-success">{{ $d->jam_in  }}</span>
                        </div>
                        <span class="badge badge-danger">{{ $d->jam_out != null ? $d->jam_out : 'Belum absen' }}</span>
                    </div>
                </div>
            </div>
        </li>
    </ul>
@endforeach
