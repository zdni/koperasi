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
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-employee" class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Unit</th>
                                <th>Posisi</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Karyawan</th>
                                <th>Unit</th>
                                <th>Posisi</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->unit->name ?? '-' }}</td>
                                <td>{{ $employee->position->name }}</td>
                                <td>
                                    <div class="form-button-action">
                                        <button class="mr-1 btn btn-sm btn-primary" data-toggle="modal" data-target="#aktifkan-karyawan-{{ $employee->id }}">
                                            Aktifkan Karyawan
                                        </button>

                                        <div class="modal fade" id="aktifkan-karyawan-{{ $employee->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="/karyawan/ubah-status/{{ $employee->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">
                                                                Aktifkan Karyawan
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input id="activity_state" name="activity_state" type="hidden" value="1" required>
                                                            <p>Yakin ingin <b>Aktifkan</b> karyawan</p>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
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