<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Region;
use App\Models\Religion;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([ 'name' => 'Admin', 'slug' => 'admin' ]);
        Role::create([ 'name' => 'Direktur', 'slug' => 'director' ]);
        Role::create([ 'name' => 'Karyawan', 'slug' => 'employee' ]);

        Position::create([ 'name' => 'Direktur' ]);
        Position::create([ 'name' => 'General Manager' ]);
        Position::create([ 'name' => 'Operator Pembukuan' ]);
        Position::create([ 'name' => 'Koordinator Wilayah' ]);
        Position::create([ 'name' => 'Karyawan' ]);

        Region::create([ 'name' => 'PUSAT' ]);
        Region::create([ 'name' => 'KEPULAUAN 1' ]);
        Region::create([ 'name' => 'KEPULAUAN 2' ]);
        Region::create([ 'name' => 'KEPULAUAN 3' ]);
        Region::create([ 'name' => 'DARATAN 1' ]);
        Region::create([ 'name' => 'DARATAN 2' ]);
        Region::create([ 'name' => 'DARATAN 3' ]);
        Region::create([ 'name' => 'MALUKU UTARA' ]);

        Religion::create(['name' => 'Islam']);
        Religion::create(['name' => 'Protestan']);
        Religion::create(['name' => 'Katolik']);
        Religion::create(['name' => 'Hindu']);
        Religion::create(['name' => 'Buddha']);
        Religion::create(['name' => 'Khonghucu']);

        Unit::create(['name' => 'Kantor Pusat']);
        Unit::create(['name' => 'Binongko', 'region_id' => 2]);

        User::create([
            'name'      => 'Administrator',
            'username'  => 'admin',
            'password'  => \bcrypt('admin'),
            'role_id'   => 1,
        ]);
        User::create([
            'name'      => 'Direktur',
            'username'  => 'director',
            'password'  => \bcrypt('director'),
            'role_id'   => 2,
        ]);
        User::create([
            'name'      => 'Jamaluddin',
            'username'  => 'jamaluddin',
            'password'  => \bcrypt('jamaluddin'),
            'role_id'   => 3,
        ]);
        User::create([
            'name'      => 'Sumitro',
            'username'  => 'sumitro',
            'password'  => \bcrypt('sumitro'),
            'role_id'   => 3,
        ]);
        User::create([
            'name'      => 'Arman',
            'username'  => 'arman',
            'password'  => \bcrypt('arman'),
            'role_id'   => 3,
        ]);

        Employee::create([
            'name'                      => 'Jamaluddin',
            'place_and_date_of_birth'   => 'Kendari, 01-01-2000',
            'identity_card_number'      => '123',
            'address'                   => 'Kendari',
            'gender'                    => 'male',
            'date_of_entry'             => '2000-01-01',
            'contact_person'            => '081234567890',
            'last_education'            => 'bachelor degree',
            'activity_state'            => true,
            'unit_id'                   => 1,
            'position_id'               => 2,
            'user_id'                   => 3,
            'religion_id'               => 1,
        ]);
        Employee::create([
            'name'                      => 'Sumitro',
            'place_and_date_of_birth'   => 'Kendari, 01-01-2000',
            'identity_card_number'      => '123',
            'address'                   => 'Kendari',
            'gender'                    => 'male',
            'date_of_entry'             => '2000-01-01',
            'contact_person'            => '081234567890',
            'last_education'            => 'bachelor degree',
            'activity_state'            => true,
            'unit_id'                   => 1,
            'position_id'               => 3,
            'user_id'                   => 4,
            'religion_id'               => 1,
        ]);
        Employee::create([
            'name'                      => 'Arman',
            'place_and_date_of_birth'   => 'Kendari, 01-01-2000',
            'identity_card_number'      => '123',
            'address'                   => 'Kendari',
            'gender'                    => 'male',
            'date_of_entry'             => '2000-01-01',
            'contact_person'            => '081234567890',
            'last_education'            => 'bachelor degree',
            'activity_state'            => true,
            'unit_id'                   => 1,
            'position_id'               => 4,
            'user_id'                   => 5,
            'religion_id'               => 1,
        ]);
        Employee::create([
            'name'                      => 'Karyawan 1',
            'place_and_date_of_birth'   => 'Kendari, 01-01-2000',
            'identity_card_number'      => '123',
            'address'                   => 'Kendari',
            'gender'                    => 'male',
            'date_of_entry'             => '2000-01-01',
            'contact_person'            => '081234567890',
            'last_education'            => 'bachelor degree',
            'activity_state'            => true,
            'unit_id'                   => 2,
            'position_id'               => 5,
            'user_id'                   => null,
            'religion_id'               => 1,
        ]);
        Employee::create([
            'name'                      => 'Karyawan 2',
            'place_and_date_of_birth'   => 'Kendari, 01-01-2000',
            'identity_card_number'      => '123',
            'address'                   => 'Kendari',
            'gender'                    => 'male',
            'date_of_entry'             => '2000-01-01',
            'contact_person'            => '081234567890',
            'last_education'            => 'bachelor degree',
            'activity_state'            => true,
            'unit_id'                   => 2,
            'position_id'               => 5,
            'user_id'                   => null,
            'religion_id'               => 1,
        ]);
    }
}
