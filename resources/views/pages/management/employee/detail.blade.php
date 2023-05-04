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
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Nama Karyawan
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $employee->name }}">
                    </div>
                </div>
                <div class="separator-solid"></div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Tempat, Tanggal Lahir
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $employee->place_and_date_of_birth }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Jenis Kelamin
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8 d-flex align-items-center">
                        <input type="text" class="form-control" disabled value="{{ $genders[$employee->gender] }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Agama
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $employee->religion->name }}">
                    </div>
                </div>
                <div class="separator-solid"></div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Nomor Identitas
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $employee->identity_card_number }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Nomor Telepon
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $employee->contact_person }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Pendidikan Terakhir
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $educations[$employee->last_education] }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Alamat
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <textarea class="form-control" disabled>{{ $employee->address }}</textarea>
                    </div>
                </div>
                <div class="separator-solid"></div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Tanggal Masuk
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $employee->date_of_entry }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Jabatan
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $employee->position->name ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Unit
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $employee->unit->name }}">
                        </select>
                    </div>
                </div>
                <div class="separator-solid"></div>
                @if(isset($employee->user->name))
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Pengguna
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $employee->user->name }}">
                        <a href="/manajemen/pengguna?id={{ $employee->user->id }}"><span class="badge badge-info mt-1">{{ $employee->user->username }}</span></a>
                    </div>
                </div>
                @endif
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                        Kontrak Karyawan
                    </label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        @if($employee->employment_contract_id)
                        <button data-toggle="modal" data-target="#edit-kontrak" class="btn  btn-border btn-info">Edit Kontrak</button>
                        <div class="modal fade" id="edit-kontrak" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="/kontrak-kerja/{{ $employee->employment_contract->id }}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">
                                                Buat Kontrak Kerja
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Judul Kontrak</label>
                                                        <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Judul Kontrak" required value="{{ $employee->employment_contract->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Total Gaji</label>
                                                        <input id="amount" name="amount" type="number" class="form-control" placeholder="Masukkan Total Gaji" required value="{{ $employee->employment_contract->amount }}">
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
                        @else
                        <button data-toggle="modal" data-target="#buat-kontrak" class="btn  btn-border btn-info">Buat Kontrak</button>
                        <div class="modal fade" id="buat-kontrak" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="/kontrak-kerja" method="post">
                                        @csrf
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">
                                                Buat Kontrak Kerja
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Judul Kontrak</label>
                                                        <input id="name" name="name" type="text" class="form-control" placeholder="Masukkan Judul Kontrak" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Total Gaji</label>
                                                        <input id="amount" name="amount" type="number" class="form-control" placeholder="Masukkan Total Gaji" required>
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
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="/karyawan/ubah/{{$employee->id}}" class="btn  btn-primary">Ubah Data</a>
                <a href="/karyawan" class="btn  btn-black btn-border">Kembali</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped" id="table-account-line">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th>Dana JHT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        @foreach($lines as $line)
                            @if($line->state == 'post')
                            <?php $total += $line->amount; ?>
                            <tr>
                                <td>{{ $months[$line->month_] }} {{ $line->year_ }}</td>
                                <td>@currency($line->amount)</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>@currency($total)</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection