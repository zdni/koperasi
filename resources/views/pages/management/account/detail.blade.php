@extends('layout.main')
@section('content')
<div class="row mt--2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-tools">
                        <button class="ml-2 btn btn-black btn-border  btn-round">
                            {{ $state }}
                        </button>
                    </div>
                </div>
            </div>
            <form action="/jht" method="post">
                @csrf
                <div class="card-body">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-md-6 form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" value="{{ $account->name }}" disabled>
                            </div>
                            <div class="col-12 col-md-3 form-group">
                                <label for="">Bulan</label>
                                <input type="text" class="form-control" value="{{ $month }}" disabled>
                            </div>
                            <div class="col-12 col-md-3 form-group">
                                <label for="">Tahun</label>
                                <input type="text" class="form-control" value="{{ $account->year }}" disabled>
                            </div>
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
                            <tbody>
                                @foreach($account->lines as $line)
                                <tr>
                                    <td>{{ $line->employee->name }}</td>
                                    <td>@currency($line->amount)</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12">
                        <a href="/dana-jht" class="btn  btn-black btn-border">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection