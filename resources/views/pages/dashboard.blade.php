@extends('layout.main')

@section('content')
    <div class="row mt--2">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-info mr-3">
                                <i class="fa fa-users"></i>
                            </span>
                            <div>
                                <h5 class="mb-1"><b><a href="/karyawan">{{ $total->employees }} <small>Karyawan</small></a></b></h5>
                                <small><a href="/manajemen/pengguna" class="text-muted">{{ $total->users }} Pengguna</a></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-primary mr-3">
                                <i class="fa fa-building"></i>
                            </span>
                            <div>
                                <h5 class="mb-1"><b><a href="/manajemen/wilayah">{{ $total->regions }} <small>Wilayah</small></a></b></h5>
                                <small><a href="/manajemen/unit" class="text-muted">{{ $total->units }} Unit</a></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card full-height">
                        <div class="card-header">
                            <div class="card-title">Aktivitas Terbaru</div>
                        </div>
                        <div class="card-body">
                            @if( !count($activities) )
                                <h4 class="text-center"><b>Tidak Ada Aktivitas Terbaru</b></h4>
                            @endif
                            <ol class="activity-feed">
                                @foreach($activities as $activity)
                                    <li class="feed-item feed-item-info">
                                        <time class="date" style="font-size: 11px;"><span class="text-primary">{{ $activity->user->name }}</span> {{ $activity->datetime }}</time>
                                        <span class="text">{{ $activity->message }}</span>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="col-12">
                <div class="card full-height">
                    <form action="/laporan/karyawan-aktif" method="post" target="_blank">
                        @csrf
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Laporan Karyawan Aktif</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="">Data</label>
                                            <select name="model" id="model" class="form-control">
                                                <option value="employee">Karyawan</option>
                                                <option value="unit">Unit</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-group" id="form-group-employee">
                                            <label for="">Karyawan</label>
                                            <div class="select2-input">
                                                <select multiple="multiple" name="employee_id[]" id="employee_id" class="form-control" style="width: 100%;">
                                                    <option value="">&nbsp;</option>
                                                    @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="form-group-unit" style="display: none;">
                                            <label for="">Unit</label>
                                            <div class="select2-input">
                                                <select multiple="multiple" name="unit_id[]" id="unit_id" class="form-control" style="width: 100%;">
                                                    <option value="">&nbsp;</option>
                                                    @foreach($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form">
                                            <div class="form-group">
                                                <label for="">Tipe Laporan</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="pdf">PDF</option>
                                                    <option value="excel">Excel</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form">
                                            <div class="form-group">
                                                <label for="">Data Dana JHT</label>
                                                <select name="data" id="data" class="form-control">
                                                    <option value="recap">Rekap</option>
                                                    <option value="detail">Detail</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <span class="btn-label mr-2">
                                    <i class="fa fa-file"></i>
                                </span>
                                Cetak Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const formGroupEmployee = document.getElementById('form-group-employee');
        const formGroupUnit = document.getElementById('form-group-unit');
        const model = document.getElementById('model');

        model.addEventListener('change', function(event) {
            if(event.target.value === 'employee') {
                formGroupEmployee.style.display = 'block';
                formGroupUnit.style.display = 'none';
            }
            if(event.target.value === 'unit') {
                formGroupEmployee.style.display = 'none';
                formGroupUnit.style.display = 'block';
            }
        })
    </script>
@endsection