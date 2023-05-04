@extends('layout.main')

@section('content')
<div class="row mt--2">
    @if (session()->has('success'))
        <div class="col-12">
            <div class="card bg-info py-2 px-4 text-white">
                <b>{{ session('success') }}</b>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="col-12">
            <div class="card bg-danger py-2 px-4 text-white">
                <b>{{ session('error') }}</b>
            </div>
        </div>
    @endif
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary  ml-auto" data-toggle="modal" data-target="#tambah-data-jabatan">
                        Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="modal fade" id="tambah-data-jabatan" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="/manajemen/jabatan" method="post">
                                @csrf
                                <div class="modal-header border-0">
                                    <h5 class="modal-title">
                                        Tambah Data
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Nama</label>
                                                <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Data Jabatan" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn  btn-primary">Simpan</button>
                                    <button type="button" class="btn  btn-danger" data-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="table-position" class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($positions as $position)
                            <tr>
                                <td>{{ $position->name }}</td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="/karyawan?position_id={{ $position->id }}" class="mr-1 btn  btn-border btn-black">
                                            Lihat Karyawan
                                        </a>
                                        <button class="mr-1 btn  btn-primary" data-toggle="modal" data-target="#edit-data-jabatan-{{ $position->id }}">
                                            Edit
                                        </button>
                                        <!-- <button class="mr-1 btn  btn-danger" data-toggle="modal" data-target="#hapus-data-jabatan-{{ $position->id }}">
                                            Hapus
                                        </button> -->

                                        <div class="modal fade" id="edit-data-jabatan-{{ $position->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="/manajemen/jabatan/{{ $position->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">
                                                                Ubah Data
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-group-default">
                                                                        <label>Nama</label>
                                                                        <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Data Jabatan" value="{{ $position->name }}" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="submit" class="btn  btn-primary">Simpan</button>
                                                            <button type="button" class="btn  btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="modal fade" id="hapus-data-jabatan-{{ $position->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="/manajemen/jabatan/{{ $position->id }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">
                                                                Hapus Data
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah anda yakin ingin menghapus data jabatan <b>{{ $position->name }}</b></p>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="submit" class="btn  btn-danger">Hapus</button>
                                                            <button type="button" class="btn  btn-border-primary" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection