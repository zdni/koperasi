<p>Laporan Jaminan Hari Tua Karyawan</p>
<p>Tanggal Penarikan: {{ $date }}</p>
<p></p>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Karyawan</th>
            <th>Unit</th>
            <th>Total JHT</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $employee)
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->unit->name ?? '-' }}</td>
            <td>{{ $employee->account_lines()->where('state', 'post')->sum('amount') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>