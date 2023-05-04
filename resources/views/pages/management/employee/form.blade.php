@extends('layout.main')
@section('content')
<div class="row mt--2">
    <div class="col-12">
        <div class="card">
            <form action="{{ $url }}" method="post">
                @csrf
                @if($method == 'put')
                @method('put')
                @endif
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Nama Karyawan
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="text" name="name" id="name" class="form-control" required placeholder="Masukkan Nama Karyawan" value="{{ (isset($employee)) ? $employee->name : '' }}">
                        </div>
                    </div>
                    <div class="separator-solid"></div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Tempat, Tanggal Lahir
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="text" name="place_and_date_of_birth" id="place_and_date_of_birth" class="form-control" required placeholder="Kota, DD-MM-YYYY" value="{{ (isset($employee)) ? $employee->place_and_date_of_birth : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Jenis Kelamin
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8 d-flex align-items-center">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="male" name="gender" class="custom-control-input" value="male" {{ !isset($employee) ? 'checked' : '' }} {{ (isset($employee) && $employee->gender == "male") ? "checked" : '' }}>
                                <label class="custom-control-label" for="male">Pria</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="female" name="gender" class="custom-control-input" value="female" {{ (isset($employee) && $employee->gender == "female") ? "checked" : '' }}>
                                <label class="custom-control-label" for="female">Wanita</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Agama
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <select name="religion_id" id="religion_id" class="form-control" required>
                                @foreach($religions as $religion)
                                <option value="{{ $religion->id }}" {{ (isset($employee) && $employee->religion_id == $religion->id) ? 'selected' : '' }}>{{ $religion->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="separator-solid"></div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Nomor Identitas
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="text" name="identity_card_number" id="identity_card_number" class="form-control" required placeholder="Masukkan Nomor Identitas" value="{{ (isset($employee)) ? $employee->identity_card_number : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Nomor Telepon
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="tel" name="contact_person" id="contact_person" class="form-control" required placeholder="Masukkan Nomor Telepon" value="{{ (isset($employee)) ? $employee->contact_person : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Pendidikan Terakhir
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <select name="last_education" id="last_education" class="form-control" required>
                                @foreach($educations as $key => $education)
                                <option value="{{ $key }}" {{ (isset($employee) && $employee->last_education == $key) ? 'selected' : '' }}>{{ $education }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Alamat
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <textarea name="address" id="address" class="form-control" required>{{ (isset($employee)) ? $employee->address : '' }}</textarea>
                        </div>
                    </div>
                    <div class="separator-solid"></div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Tanggal Masuk
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="date" name="date_of_entry" id="date_of_entry" class="form-control" required value="{{ (isset($employee)) ? $employee->date_of_entry : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Jabatan
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <select name="position_id" id="position_id" class="form-control" required>
                                @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ (isset($employee) && $employee->position_id == $position->id) ? 'selected' : '' }}>{{ $position->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Unit
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <select name="unit_id" id="unit_id" class="form-control" required>
                                @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ (isset($employee) && $employee->unit_id == $unit->id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="separator-solid"></div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
                            Pengguna
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">Tidak Ada Pengguna</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ ($user_id == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12">
                        <button type="submit" class="btn  btn-primary">Simpan</button>
                        <a href="/karyawan" class="btn  btn-black btn-border">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection