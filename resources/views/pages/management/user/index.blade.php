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
                    <button class="btn btn-primary  ml-auto" data-toggle="modal" data-target="#tambah-data-pengguna">
                        Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="modal fade" id="tambah-data-pengguna" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="/manajemen/pengguna" method="post">
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
                                                <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Data Pengguna" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Username</label>
                                                <input id="username" name="username" type="text" class="form-control" placeholder="Masukkan Username" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Role</label>
                                                <select name="role_id" id="role_id" class="form-control">
                                                    @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <span class="text-muted font-weight-bold text-small text-danger">*Harap gunakan huruf kecil untuk username. username akan menjadi default password.</span>
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
                    <table id="table-user" class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    {{ $user->name }}
                                    <br>
                                    <span class="badge badge-count">{{ $state[$user->state] }}</span>
                                </td>
                                <td>
                                    {{ $user->username }}
                                    <br>
                                    <span class="badge badge-info">{{ $user->role->name }}</span>
                                </td>
                                <td>
                                    <div class="form-button-action">
                                        @if(count($user->employees))
                                            <a href="/manajemen/pengguna/alihkan-ke-karyawan?user_id={{ $user->id }}" class="mr-1 btn  btn-primary">Lihat Karyawan</a>
                                        @else
                                            <a href="/karyawan/buat?user_id={{ $user->id }}" class="mr-1 btn  btn-primary">Buat Karyawan</a>
                                        @endif
                                        <button class="mr-1 btn  btn-info" data-toggle="modal" data-target="#edit-data-pengguna-{{ $user->id }}">
                                            Edit
                                        </button>
                                    </div>
                                    <div class="modal fade" id="edit-data-pengguna-{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="/manajemen/pengguna/{{ $user->id }}" method="post">
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
                                                                    <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Data Pengguna" value="{{ $user->name }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group form-group-default">
                                                                    <label>Password</label>
                                                                    <input id="password" name="password" type="text" class="form-control" placeholder="Masukkan Data Password">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group form-group-default">
                                                                    <label>Role</label>
                                                                    <select name="role_id" id="role_id" class="form-control">
                                                                        @foreach($roles as $role)
                                                                        <option  value="{{ $role->id }}" {{ ($user->role_id == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group form-group-default">
                                                                    <label>Role</label>
                                                                    <select name="state" id="state" class="form-control">
                                                                        <option {{ ($user->state == 0) ? 'selected' : '' }} value="0">Nonaktif</option>
                                                                        <option {{ ($user->state == 1) ? 'selected' : '' }} value="1">Aktif</option>
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
