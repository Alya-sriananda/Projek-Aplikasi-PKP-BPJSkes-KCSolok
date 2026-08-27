<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Batch {{ $batch->id }}
    </title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f6f8;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
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

        .back {
            background: #6b7280;
        }

    </style>

</head>

<body>

<div class="container">

    <div style="margin-bottom: 20px;">

        <a
            href="{{ route('batches.index') }}"
            class="button back"
        >
            ← Kembali
        </a>

    </div>


    @if(session('success'))

        <div
            class="card"
            style="background: #dcfce7;"
        >
            {{ session('success') }}
        </div>

    @endif


    <div class="card">

        <h1>
            Batch #{{ $batch->id }}
        </h1>

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

    </div>


    <div class="card">

        <h2>
            Daftar Peserta
        </h2>

        @if($batch->pesertas->count())

            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>No Kartu</th>

                        <th>Nama</th>

                        <th>No HP</th>

                        <th>Email</th>

                        <th>Status Aktif</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($batch->pesertas as $peserta)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $peserta->noka }}
                            </td>

                            <td>
                                {{ $peserta->nama }}
                            </td>

                            <td>
                                {{ $peserta->no_hp ?? '-' }}
                            </td>

                            <td>
                                {{ $peserta->email ?? '-' }}
                            </td>

                            <td>
                                {{ $peserta->status_aktif ?? '-' }}
                            </td>

                            <td>

                                <a
                                    href="{{ route('verifikasi-sipp.create', $peserta) }}"
                                    class="button"
                                >
                                    Verifikasi
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>
                Tidak ada peserta dalam batch ini.
            </p>

        @endif

    </div>

</div>

</body>

</html>