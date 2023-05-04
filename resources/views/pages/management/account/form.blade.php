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
    <input type="hidden" name="id" id="id" value="{{ $account->id }}">
    <input type="hidden" name="month" id="month" value="{{ $account->month }}">
    <input type="hidden" name="year" id="year" value="{{ $account->year }}">
    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">

    <div class="col-12">
        <div class="row">
            <div class="col-md-6 col-lg-4 col-12">
                <div class="card">
                    <form id="form-create-account-line" name="form-create-account-line">
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Karyawan</label>
                                            <div class="select2-input">
                                                <select name="employee_id" id="employee_id" class="form-control" style="width: 100%">
                                                    <option value="">&nbsp;</option>
                                                    @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Jumlah JHT</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp</div>
                                                </div>
                                                <input type="number" name="amount" id="amount" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12">
                                <button type="button" class="btn  btn-primary" data-dismiss="modal" id="create-line">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-lg-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">
                                <button class="btn btn-danger btn-border " data-toggle="modal" data-target="#batalkan-jht">
                                    Batalkan JHT
                                </button>
                                <button class="btn btn-info btn-border " data-toggle="modal" data-target="#validasi-jht">
                                    Validasi JHT
                                </button>

                                <div class="modal fade" id="batalkan-jht" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="/batalkan-jht/{{ $account->id }}" method="post">
                                                @csrf
                                                @method('put')
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title">
                                                        Batalkan JHT
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-12">
                                                        <input id="id" name="id" type="hidden" class="form-control" value="{{ $account->id }}" required>
                                                        <input id="state" name="state" type="hidden" class="form-control" value="cancel" required>
                                                        <div class="row">
                                                            <p>Yakin ingin membatalkan dokumen JHT yang telah dibuat?</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="submit" class="btn  btn-danger">Batalkan</button>
                                                    <button type="button" class="btn  btn-info btn-border" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="validasi-jht" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="/validasi-jht/{{ $account->id }}" method="post">
                                                @csrf
                                                @method('put')
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title">
                                                        Validasi JHT
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-12">
                                                        <input id="id" name="id" type="hidden" class="form-control" value="{{ $account->id }}" required>
                                                        <input id="state" name="state" type="hidden" class="form-control" value="post" required>
                                                        <div class="row">
                                                            <p>Yakin ingin memvalidasi dokumen JHT yang telah dibuat?</p>
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
                            </div>
                            <div class="card-tools">
                                <button class="ml-2 btn btn-black btn-border  btn-round">
                                    {{ $state[$account->state] }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" value="{{ $account->name }}" disabled>
                            </div>
                            <div class="col-12 col-md-3 form-group">
                                <label for="">Bulan</label>
                                <input type="text" class="form-control" value="{{ $months[$account->month] }}" disabled>
                            </div>
                            <div class="col-12 col-md-3 form-group">
                                <label for="">Tahun</label>
                                <input type="text" class="form-control" value="{{ $account->year }}" disabled>
                            </div>
                        </div>
                        <div class="col-12 mt-5">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Karyawan</th>
                                        <th>Jumlah JHT</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-account">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-12">
                            <a href="/dana-jht" class="btn  btn-black btn-border">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection