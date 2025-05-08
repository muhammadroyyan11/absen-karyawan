@extends('layout.admin.admin')

@section('admin-contents')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h3 class="mb-4">
                Groaming / {{ ucfirst($level) }}
                @if(!empty($path))
                    <small class="text-muted">/ {{ implode(' / ', $path) }}</small>
                @endif
            </h3>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <section class="content">

            <div class="row" id="folderGrid">
                @foreach($folders as $folder)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="box">
                            <div class="box-body text-center">
                                <i class="fa fa-folder" style="font-size: 50px; color: #757575;"></i>
                                <h5 class="card-title mt-2">
                                    {{--                                    {{ is_numeric($folder) && strlen($folder) === 1 ? str_pad($folder, 2, '0', STR_PAD_LEFT) : $folder }}--}}
                                    {{ htmlspecialchars($folder->user_name) }}
                                </h5>

                                @php
                                    $nextRoute = match($level) {
                                        'year' => route('drive.months', [$folder]),
                                        'month' => route('drive.dates', [$year, $folder]),
                                        'day' => route('drive.staff', [$year, $month, $folder]),
                                        'staff' => route('drive.photos', [$year, $month, $day, $folder->user_name]),
                                        default => '#',
                                    };
                                @endphp

                                <a href="{{ $nextRoute }}" class="btn btn-primary btn-sm">Open</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
