<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Batch</title>

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
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .button {
            display: inline-block;
            padding: 8px 12px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .button:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <h1>Data Batch Peserta REHAB</h1>

        <a
            href="{{ route('batches.create') }}"
            class="button"
        >
            + Import Excel
        </a>

    </div>


    @if(session('success'))

        <div style="padding: 12px; background: #dcfce7; margin-bottom: 20px;">
            {{ session('success') }}
        </div>

    @endif


    @if($batches->count())

        <table>

            <thead>

                <tr>
                    <th>No</th>
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
                            {{ $batches->firstItem() + $loop->index }}
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

        <p>
            Belum ada data batch.
        </p>

    @endif

</div>

</body>
</html>