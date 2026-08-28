<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data Batch - Monitoring Peserta REHAB</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 40px;
        background: #f5f6f8;
    }

    .container {
        max-width: 1100px;
        margin: auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .card {
        background: white;
        padding: 25px;
        border-radius: 8px;
    }

    .button {
        display: inline-block;
        padding: 10px 15px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    th {
        background: #f9fafb;
    }

    .success {
        background: #dcfce7;
        color: #166534;
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .empty {
        text-align: center;
        padding: 30px;
        color: #6b7280;
    }
</style>

</head>

<body>

<div class="container">

<div class="header">
    <div>
        <h1>Data Batch</h1>
        <p>Daftar import data peserta REHAB.</p>
    </div>

    <a href="{{ route('batches.create') }}" class="button">
        + Import Excel
    </a>
</div>

@if(session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif

<div class="card">

    @if($batches->count())

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal Data</th>
                    <th>Nama File</th>
                    <th>Jumlah Peserta</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($batches as $batch)

                    <tr>

                        <td>
                            {{ $batch->id }}
                        </td>

                        <td>
                            {{ $batch->tanggal_data->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $batch->nama_file }}
                        </td>

                        <td>
                            {{ $batch->pesertas_count }}
                        </td>

                        <td>
                            <a
                                href="{{ route('batches.show', $batch) }}"
                                class="button"
                            >
                                Lihat Peserta
                            </a>
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        <div style="margin-top: 20px;">
            {{ $batches->links() }}
        </div>

    @else

        <div class="empty">
            Belum ada data batch.
        </div>

    @endif

</div>
</div>

</body>
</html>
