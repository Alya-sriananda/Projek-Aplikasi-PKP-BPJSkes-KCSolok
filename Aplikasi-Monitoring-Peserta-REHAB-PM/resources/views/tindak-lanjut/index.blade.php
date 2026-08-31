<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Tindak Lanjut Peserta
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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 9px 14px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back {
            background: #6b7280;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
        }

        .badge-new {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-status {
            background: #fee2e2;
            color: #991b1b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .empty {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }

        .summary {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .summary-box {
            flex: 1;
            min-width: 180px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 6px;
        }

        .summary-number {
            font-size: 28px;
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    {{-- Header --}}
    <div class="header">

        <div>
            <h1>
                Daftar Tindak Lanjut
            </h1>

            @if($batch)
                <p>
                    Batch #{{ $batch->id }}
                    —
                    {{ $batch->tanggal_data->format('d-m-Y') }}
                </p>
            @endif
        </div>

        <div>
            <a
                href="{{ route('batches.index') }}"
                class="button back"
            >
                ← Daftar Batch
            </a>
        </div>

    </div>


    {{-- Jika belum ada batch --}}
    @if(!$batch)

        <div class="card empty">
            <h3>
                Belum ada data batch
            </h3>

            <p>
                Silakan import data peserta terlebih dahulu.
            </p>
        </div>

    @else

        {{-- Informasi Batch --}}
        <div class="card">

            <h2>
                Batch Terbaru
            </h2>

            <p>
                <strong>Batch:</strong>
                #{{ $batch->id }}
            </p>

            <p>
                <strong>Tanggal Data:</strong>
                {{ $batch->tanggal_data->format('d-m-Y') }}
            </p>

            <p>
                <strong>File:</strong>
                {{ $batch->nama_file }}
            </p>

            <p>
                <strong>Total Peserta dalam Batch:</strong>
                {{ $batch->jumlah_data }}
            </p>

        </div>


        {{-- Ringkasan --}}
        <div class="card">

            <div class="summary">

                <div class="summary-box">

                    <div>
                        Peserta Harus Ditindaklanjuti
                    </div>

                    <div class="summary-number">
                        {{ $peserta->count() }}
                    </div>

                </div>

            </div>

        </div>


        {{-- Daftar Peserta --}}
        <div class="card">

            <h2>
                Peserta yang Harus Ditindaklanjuti
            </h2>

            @if($peserta->count())

                <table>

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>No Kartu</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($peserta as $item)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $item->noka }}
                                </td>

                                <td>
                                    {{ $item->nama }}
                                </td>

                                <td>
                                    {{ $item->no_hp ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->email ?? '-' }}
                                </td>

                                <td>

                                    @if($item->kategori_tindak_lanjut === 'peserta_baru')

                                        <span class="badge badge-new">
                                            Peserta Baru
                                        </span>

                                    @elseif($item->kategori_tindak_lanjut === 'belum_diproses')

                                        <span class="badge badge-pending">
                                            Belum Diproses
                                        </span>

                                    @else

                                        <span class="badge">
                                            {{ $item->kategori_tindak_lanjut }}
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <span class="badge badge-status">
                                        Belum Diproses
                                    </span>

                                </td>

                                <td>

                                    <a
                                        href="{{ route('verifikasi-sipp.create', $item) }}"
                                        class="button"
                                    >
                                        Proses
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="empty">

                    <h3>
                        Tidak ada peserta yang perlu ditindaklanjuti
                    </h3>

                    <p>
                        Semua peserta pada batch terbaru sudah diproses
                        atau belum memenuhi kriteria tindak lanjut.
                    </p>

                </div>

            @endif

        </div>

    @endif

</div>

</body>

</html>