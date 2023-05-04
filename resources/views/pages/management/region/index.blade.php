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
                    <button class="btn btn-primary  ml-auto" data-toggle="modal" data-target="#tambah-data-wilayah">
                        Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="modal fade" id="tambah-data-wilayah" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="/manajemen/wilayah" method="post">
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
                                                <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Data Wilayah" required>
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
                    <table id="table-region" class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>Wilayah</th>
                                <th>GM</th>
                                <th>Pembukuan</th>
                                <th>Koordinator</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Wilayah</th>
                                <th>GM</th>
                                <th>Pembukuan</th>
                                <th>Koordinator</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($regions as $region)
                            <tr>
                                <td>{{ $region->name }}</td>
                                <td>{{ $region->region_leaderships->first()->gm_employee->name ?? '-' }}</td>
                                <td>{{ $region->region_leaderships->first()->accountant_employee->name ?? '-' }}</td>
                                <td>{{ $region->region_leaderships->first()->coordinator_employee->name ?? '-' }}</td>
                                <td>
                                    <div class="form-button-action">
                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown">
                                                <span class="btn-label">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <button class="dropdown-item" data-toggle="modal" data-target="#atur-adm-wilayah-{{ $region->id }}">
                                                        Atur Adm. Wliayah
                                                    </button>
                                                    <a href="/manajemen/unit?region_id={{ $region->id }}" class="dropdown-item">
                                                        Lihat Unit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item text-info" data-toggle="modal" data-target="#edit-data-wilayah-{{ $region->id }}">
                                                        Edit
                                                    </button>
                                                    <button class="dropdown-item text-danger" data-toggle="modal" data-target="#hapus-data-wilayah-{{ $region->id }}">
                                                        Hapus
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="modal fade" id="atur-adm-wilayah-{{ $region->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="/manajemen/wilayah/atur-adm-wilayah" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">
                                                                Adm Wilayah {{ $region->name }}
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <input id="region_id" name="region_id" type="hidden" value="{{ $region->id }}" required>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-group-default">
                                                                        <label>General Manajer</label>
                                                                        <select name="gm_employee_id" id="gm_employee_id" class="form-control" required>
                                                                            @foreach($gm_employees as $gm_employee)
                                                                            <option value="{{ $gm_employee->id }}" {{ (isset($region->region_leaderships->first()->gm_employee->id) && $region->region_leaderships->first()->gm_employee->id == $gm_employee->id) ? 'selected' : '' }}>{{ $gm_employee->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-group-default">
                                                                        <label>Koordinator</label>
                                                                        <select name="coordinator_employee_id" id="coordinator_employee_id" class="form-control" required>
                                                                            @foreach($coo_employees as $coo_employee)
                                                                            <option value="{{ $coo_employee->id }}" {{ (isset($region->region_leaderships->first()->coo_employee->id) && $region->region_leaderships->first()->coo_employee->id == $coo_employee->id) ? 'selected' : '' }}>{{ $coo_employee->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-group-default">
                                                                        <label>Pembukuan</label>
                                                                        <select name="accountant_employee_id" id="accountant_employee_id" class="form-control" required>
                                                                            @foreach($accountant_employees as $accountant_employee)
                                                                            <option value="{{ $accountant_employee->id }}" {{ (isset($region->region_leaderships->first()->accountant_employee->id) && $region->region_leaderships->first()->accountant_employee->id == $accountant_employee->id) ? 'selected' : '' }}>{{ $accountant_employee->name }}</option>
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
                                        <div class="modal fade" id="edit-data-wilayah-{{ $region->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="/manajemen/wilayah/{{ $region->id }}" method="post">
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
                                                                        <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Data Wilayah" value="{{ $region->name }}" required>
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
                                        <div class="modal fade" id="hapus-data-wilayah-{{ $region->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="/manajemen/wilayah/{{ $region->id }}" method="post">
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
                                                            <p>Apakah anda yakin ingin menghapus data wilayah <b>{{ $region->name }}</b></p>
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