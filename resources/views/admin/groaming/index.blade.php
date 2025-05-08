@extends('layout.admin.admin')

@section('admin-contents')
    <!-- Content Wrapper. Contains page content -->
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

        <!-- Main content -->
        <section class="content">
            <!-- Folder View Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row d-flex justify-content-start" id="folderGrid">
                        <!-- Example Folder Cards -->
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="box">
                                <div class="box-body text-center">
                                    <i class="fa fa-folder" style="font-size: 50px; color: #757575;"></i> <!-- Default Folder Icon -->
                                    <h5 class="card-title mt-2">MALANG</h5>
                                    <a href="#" class="btn btn-primary btn-sm">Open</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="box">
                                <div class="box-body text-center">
                                    <i class="fa fa-folder" style="font-size: 50px; color: #757575;"></i> <!-- Default Folder Icon -->
                                    <h5 class="card-title mt-2">MALANG</h5>
                                    <a href="#" class="btn btn-primary btn-sm">Open</a>
                                </div>
                            </div>
                        </div>
                        <!-- More folder examples here -->
                    </div>
                </div>
            </div>
        </section>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('custom')
    <script>
        // Simulate creating a folder dynamically
        document.getElementById('createFolderBtn').addEventListener('click', function () {
            const folderGrid = document.getElementById('folderGrid');
            const newFolder = document.createElement('div');
            newFolder.classList.add('col-lg-3', 'col-md-4', 'col-sm-6', 'mb-3');
            newFolder.innerHTML = `
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fa fa-folder" style="font-size: 50px; color: #757575;"></i> <!-- Default Folder Icon -->
                        <h5 class="card-title mt-2">New Folder</h5>
                        <p class="card-text">Description or detail about new folder.</p>
                        <a href="#" class="btn btn-primary btn-sm">Open</a>
                    </div>
                </div>
            `;
            folderGrid.appendChild(newFolder);
        });
    </script>
@endpush
