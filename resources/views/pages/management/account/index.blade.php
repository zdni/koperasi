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
                    <button class="btn btn-primary  ml-auto" data-toggle="modal" data-target="#tambah-data-jht">
                        Buat Dokumen Dana JHT
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="modal fade" id="tambah-data-jht" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="/buat-jht" method="post">
                                @csrf
                                <div class="modal-header border-0">
                                    <h5 class="modal-title">
                                        Buat Dokumen Dana JHT
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group form-group-default">
                                                <label>Nama</label>
                                                <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Data Account" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
												<label>Input Date Picker</label>
												<div class="input-group">
													<input type="text" class="form-control" id="period" name="period">
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="fa fa-calendar-check"></i>
														</span>
													</div>
												</div>
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
                    <table id="table-account" class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Status</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama</th>
                                <th>Status</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($accounts as $account)
                            <tr>
                                <td>{{ $account->name }}</td>
                                <td>{{ $state[$account->state] }}</td>
                                <td>
                                    <div class="form-button-action">
                                        @if($account->state == 'draft')
                                        <button class="mr-1 btn  btn-primary" data-toggle="modal" data-target="#edit-{{ $account->id }}">
                                            Edit
                                        </button>

                                        <div class="modal fade" id="edit-{{ $account->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="/dana-jht/{{ $account->id }}" method="post">
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
                                                                <div class="col-12">
                                                                    <div class="form-group form-group-default">
                                                                        <label>Nama</label>
                                                                        <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Nama" value="{{ $account->name }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Input Date Picker</label>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="period_" name="period_" value="{{ $account->month }}-{{ $account->year }}">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-calendar-check"></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
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

                                        <a href="/input-jht/{{ $account->id }}" class="mr-1 btn  btn-border btn-black">
                                            Lihat
                                        </a>
                                        @else
                                        <a href="/detail-jht/{{ $account->id }}" class="mr-1 btn  btn-border btn-black">
                                            Lihat
                                        </a>
                                        @endif
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