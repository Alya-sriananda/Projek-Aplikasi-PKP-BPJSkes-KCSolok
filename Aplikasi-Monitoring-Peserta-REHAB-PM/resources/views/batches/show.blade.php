<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Batch</title>
</head>
<body>

    <h1>Data Peserta REHAB</h1>

    <p>
        <strong>Tanggal Data:</strong>
        {{ $batch->tanggal_data->format('d-m-Y') }}
    </p>

    <p>
        <strong>Nama File:</strong>
        {{ $batch->nama_file }}
    </p>

    <p>
        <strong>Jumlah Peserta:</strong>
        {{ $batch->jumlah_data }}
    </p>

    <hr>

    <h2>Daftar Peserta</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>No Kartu</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Email</th>
                <th>Status Aktif</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($batch->pesertas as $index => $peserta)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $peserta->noka }}</td>
                    <td>{{ $peserta->nama }}</td>
                    <td>{{ $peserta->no_hp ?? '-' }}</td>
                    <td>{{ $peserta->email ?? '-' }}</td>
                    <td>{{ $peserta->status_aktif ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        Belum ada peserta.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>