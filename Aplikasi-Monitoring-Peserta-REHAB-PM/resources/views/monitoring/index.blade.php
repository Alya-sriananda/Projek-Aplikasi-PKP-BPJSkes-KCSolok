<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Monitoring Peserta - Batch {{ $batch->id }}
    </title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f6f8;
        }

        .container {
            max-width: 1400px;
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
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .stat {
            background: white;
            padding: 18px;
            border-radius: 8px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            margin-top: 5px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .button {
            display: inline-block;
            padding: 7px 10px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .button-primary {
            background: #2563eb;
            color: white;
        }

        .button-success {
            background: #16a34a;
            color: white;
        }

        .button-secondary {
            background: #6b7280;
            color: white;
        }

        .button-email {
            background: #7c3aed;
            color: white;
        }

        .filter {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        input,
        select {
            padding: 9px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #6b7280;
        }

        @media (max-width: 900px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>

<div class="container">

    {{-- HEADER --}}
    <div class="card">

        <div class="header">

            <div>
                <h1>
                    Monitoring Peserta
                </h1>

                <p>
                    Batch {{ $batch->id }}
                    —
                    {{ $batch->nama_file }}
                </p>

                <p>
                    Tanggal Data:
                    <strong>
                        {{ $batch->tanggal_data?->format('d-m-Y') }}
                    </strong>
                </p>
            </div>

            <div>
                <a
                    href="{{ route('batches.show', $batch) }}"
                    class="button button-secondary"
                >
                    ← Kembali ke Batch
                </a>
            </div>

        </div>

    </div>


    {{-- PERIODE --}}
    <div class="card">

        <strong>Periode Tagihan</strong>

        <p>
            Sebelum bulan berjalan:
            <strong>
                {{ $periode['bulan_sebelumnya'] }}
            </strong>
        </p>

        <p>
            Bulan berjalan:
            <strong>
                {{ $periode['bulan_berjalan'] }}
            </strong>
        </p>

    </div>


    {{-- STATISTIK --}}
    <div class="stats">

        <div class="stat">
            Total Peserta

            <div class="stat-number">
                {{ $statistik['total'] }}
            </div>
        </div>

        <div class="stat">
            Belum Diverifikasi

            <div class="stat-number">
                {{ $statistik['belum_diverifikasi'] }}
            </div>
        </div>

        <div class="stat">
            Masih Ada Tunggakan

            <div class="stat-number">
                {{ $statistik['masih_ada_tunggakan'] }}
            </div>
        </div>

        <div class="stat">
            Belum Bayar {{ $periode['bulan_berjalan'] }}

            <div class="stat-number">
                {{ $statistik['belum_bayar_bulan_berjalan'] }}
            </div>
        </div>

    </div>


    {{-- FILTER --}}
    <div class="card">

        <form method="GET">

            <div class="filter">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, NOKA, HP, email..."
                >

                <select name="status">

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="belum_diverifikasi"
                        @selected(request('status') === 'belum_diverifikasi')
                    >
                        Belum Diverifikasi
                    </option>

                    <option
                        value="tidak_rehab"
                        @selected(request('status') === 'tidak_rehab')
                    >
                        Tidak REHAB
                    </option>

                    <option
                        value="masih_ada_tunggakan"
                        @selected(request('status') === 'masih_ada_tunggakan')
                    >
                        Masih Ada Tunggakan
                    </option>

                    <option
                        value="belum_bayar_bulan_berjalan"
                        @selected(request('status') === 'belum_bayar_bulan_berjalan')
                    >
                        Belum Bayar Bulan Berjalan
                    </option>

                    <option
                        value="sudah_bayar"
                        @selected(request('status') === 'sudah_bayar')
                    >
                        Sudah Bayar
                    </option>

                    <option
                        value="perlu_dicek"
                        @selected(request('status') === 'perlu_dicek')
                    >
                        Perlu Dicek
                    </option>

                </select>

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Terapkan
                </button>

                <a
                    href="{{ route('monitoring.index', $batch) }}"
                    class="button button-secondary"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- TABLE --}}
    <div class="card">

        <div class="table-wrapper">

            <table>

                <thead>

                <tr>

                    <th>No</th>

                    <th>Peserta</th>

                    <th>Kontak</th>

                    <th>
                        {{ $periode['bulan_sebelumnya'] }}
                    </th>

                    <th>
                        {{ $periode['bulan_berjalan'] }}
                    </th>

                    <th>Status</th>

                    <th>Verifikasi Terakhir</th>

                    <th>Aksi</th>

                </tr>

                </thead>

                <tbody>

                @forelse($pesertas as $index => $peserta)

                    @php
                        $verifikasi = $peserta->verifikasiTerakhir;

                        $tagihanSebelumnya =
                            $verifikasi?->tagihan_sebelum_bulan_berjalan ?? 0;

                        $tagihanBerjalan =
                            $verifikasi?->tagihan_bulan_berjalan ?? 0;
                    @endphp

                    <tr>

                        <td>
                            {{ $index + 1 }}
                        </td>

                        <td>

                            <strong>
                                {{ $peserta->nama }}
                            </strong>

                            <br>

                            <small>
                                NOKA:
                                {{ $peserta->noka }}
                            </small>

                        </td>

                        <td>

                            {{ $peserta->no_hp ?? '-' }}

                            <br>

                            <small>
                                {{ $peserta->email ?? '-' }}
                            </small>

                        </td>

                        <td>
                            Rp{{ number_format(
                                $tagihanSebelumnya,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td>
                            Rp{{ number_format(
                                $tagihanBerjalan,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td>

                            <span
                                class="badge badge-{{ $peserta->status_monitoring['tipe'] }}"
                            >
                                {{ $peserta->status_monitoring['label'] }}
                            </span>

                        </td>

                        <td>

                            @if($verifikasi)

                                {{ $verifikasi->tanggal_cek?->format('d-m-Y') }}

                            @else

                                Belum ada

                            @endif

                        </td>

                        <td>

                            <a
                                href="{{ route(
                                    'verifikasi-sipp.create',
                                    $peserta
                                ) }}"
                                class="button button-primary"
                            >
                                Verifikasi
                            </a>

                            @if($peserta->no_hp)

                                <a
                                    href="https://wa.me/{{ preg_replace(
                                        '/^0/',
                                        '62',
                                        preg_replace(
                                            '/[^0-9]/',
                                            '',
                                            $peserta->no_hp
                                        )
                                    ) }}"
                                    target="_blank"
                                    class="button button-success"
                                >
                                    WhatsApp
                                </a>

                            @endif

                            @if($peserta->email)

                                <a
                                    href="mailto:{{ $peserta->email }}"
                                    class="button button-email"
                                >
                                    Email
                                </a>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="empty"
                        >
                            Tidak ada data peserta.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>