@extends('layout.main')

@section('button-header')
<div class="ml-md-auto py-2 py-md-0">
    <a href="/karyawan/buat" class="btn btn-white ">Tambah Karyawan</a>
</div>
@endsection

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
    @if (!count($employees))
        <div class="pt-5 col-12 text-center">
            <p>Tidak Ada Data Karyawan</p>    
            <a href="/karyawan/buat" class="btn  btn-primary">Buat Karyawan Baru</a>
        </div>
    @endif
    @foreach($employees as $employee)
        <div class="col-md-6 col-lg-4">
            <div class="card card-dark bg-info-gradient">
                <div class="card-body bubble-shadow">
                    <span>Total Dana JHT</span>
                    <div class="row pt-1 pb-4 mb-0">
                        <div class="col-10 pr-0">
                            <h2>@currency($employee->account_lines()->where('state', 'post')->sum('amount'))</h2>
                        </div>
                        <div class="col-2 pl-0 text-right">
                            <span class="badge">{{ $state[$employee->activity_state] }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7 pr-0">
                            <h3 class="fw-bold mb-1">{{ $employee->name }}</h3>
                            <div class="text-small text-uppercase fw-bold op-8">{{ $employee->identity_card_number }}</div>
                        </div>
                        <div class="col-5 pl-0 text-right">
                            <h3 class="fw-bold mb-1">{{ $employee->unit->name ?? '-' }}</h3>
                            <div class="text-small text-uppercase fw-bold op-8">{{ $employee->position->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="/karyawan/{{ $employee->id }}" class="btn btn-white btn-xs mr-1">
                            Lihat
                        </a>
                        <button data-toggle="modal" data-target="#ubah-status-karyawan-{{ $employee->id }}" class="btn btn-border btn-white btn-xs">
                            Nonaktifkan
                        </button>
                        <button data-toggle="modal" data-target="#ambil-dana-jht-{{ $employee->id }}" class="btn btn-border btn-white btn-xs">
                            Cairkan Dana JHT
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ubah-status-karyawan-{{ $employee->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/karyawan/ubah-status/{{ $employee->id }}" method="post">
                        @csrf
                        @method('put')
                        <div class="modal-header border-0">
                            <h5 class="modal-title">
                                Nonaktifkan Karyawan
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input id="activity_state" name="activity_state" type="hidden" value="0" required>
                            <p>Yakin ingin <b>Menonaktifkan</b> karyawan?</p>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-danger">Simpan</button>
                            <button type="button" class="btn btn-primary btn-border" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ambil-dana-jht-{{ $employee->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/karyawan/ambil-dana-jht/{{ $employee->id }}" method="post">
                        @csrf
                        @method('put')
                        <div class="modal-header border-0">
                            <h5 class="modal-title">
                                Ambil Dana JHT Karyawan
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <input type="hidden" name="id" id="id" value="{{ $employee->id }}">
                                <p>Yakin ingin Mengambil Dana JHT karyawan?</p>
                                <div class="form-check">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="change_activity" name="change_activity">
                                        <label class="custom-control-label" for="change_activity">Nonaktifkan Karyawan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-danger">Simpan</button>
                            <button type="button" class="btn btn-primary btn-border" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@if ($is_paginate)
    <div class="d-flex">
        {{ $employees->links() }}
    </div>
@endif
@endsection