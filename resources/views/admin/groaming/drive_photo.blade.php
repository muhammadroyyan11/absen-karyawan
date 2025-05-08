@extends('layout.admin.admin')

@section('admin-contents')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>
        <section class="content">
            <h3 class="mb-4">Foto Presensi <small class="text-muted">/ {{ implode(' / ', $path) }}</small></h3>

            <div class="row">
                @forelse($photos as $photo)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                        <img src="{{ Storage::url('uploads/absensi/' . $photo) }}" class="img-thumbnail" alt="Foto">
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">Tidak ada foto ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
