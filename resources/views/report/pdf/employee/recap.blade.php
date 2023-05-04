<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Jaminan Hari Tua Karyawan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <p class="text-center font-weight-bold">Laporan Jaminan Hari Tua Karyawan</p>
    <p class="text-center" style="font-size: 12px;">Tanggal Penarikan: {{ $date }}</p>
    <div class="mt-5" style="font-size: 12px;">
        <table class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Karyawan</th>
                    <th>Unit</th>
                    <th>Total JHT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $employee)
                <tr>
                    <td width="5%">{{ $loop->index+1 }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->unit->name ?? '-' }}</td>
                    <td>@currency($employee->account_lines()->where('stated', 'post')->sum('amount'))</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>