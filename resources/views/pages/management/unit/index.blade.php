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
                    <button class="btn btn-primary  ml-auto" data-toggle="modal" data-target="#tambah-data-unit">
                        Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="modal fade" id="tambah-data-unit" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="/manajemen/unit" method="post">
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
                                                <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Data Unit" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Wilayah</label>
                                                <select id="region_id" name="region_id" class="form-control">
                                                    @foreach($regions as $region)
                                                    <option value="{{ $region->id }}" {{ ($region_id == $region->id) ? 'selected' : '' }}>{{ $region->name }}</option>
                                                    @endforeach
                                                </select>
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
                    <table id="table-unit" class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>Unit</th>
                                <th>Wilayah</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Unit</th>
                                <th>Wilayah</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($units as $unit)
                            <tr>
                                <td>{{ $unit->name }}</td>
                                <td>{{ $unit->region->name ?? '-' }}</td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="/karyawan?unit_id={{ $unit->id }}" class="mr-1 btn  btn-border btn-black">
                                            Lihat Karyawan
                                        </a>
                                        <button class="mr-1 btn  btn-primary" data-toggle="modal" data-target="#edit-data-unit-{{ $unit->id }}">
                                            Edit
                                        </button>
                                        <button class="mr-1 btn  btn-danger" data-toggle="modal" data-target="#hapus-data-unit-{{ $unit->id }}">
                                            Hapus
                                        </button>

                                        <div class="modal fade" id="edit-data-unit-{{ $unit->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="/manajemen/unit/{{ $unit->id }}" method="post">
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
                                                                        <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Data Unit" value="{{ $unit->name }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-group-default">
                                                                        <label>Wilayah</label>
                                                                        <select id="region_id" name="region_id" class="form-control">
                                                                            @foreach($regions as $region)
                                                                            <option value="{{ $region->id }}" {{ (optional($unit->region)->id == $region->id) ? 'selected' : '' }}>{{ $region->name }}</option>
                                                                            @endforeach
                                                                        </select>
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
                                        <div class="modal fade" id="hapus-data-unit-{{ $unit->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="/manajemen/unit/{{ $unit->id }}" method="post">
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
                                                            <p>Apakah anda yakin ingin menghapus data unit <b>{{ $unit->name }}</b></p>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="submit" class="btn  btn-danger">Hapus</button>
                                                            <button type="button" class="btn  btn-border-primary" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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