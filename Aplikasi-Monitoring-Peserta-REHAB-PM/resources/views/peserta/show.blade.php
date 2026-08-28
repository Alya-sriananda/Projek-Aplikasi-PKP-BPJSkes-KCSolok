<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Detail Peserta - {{ $peserta->nama }}
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

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .item {
            padding: 12px;
            background: #f9fafb;
            border-radius: 6px;
        }

        .label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .value {
            font-weight: bold;
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

        .button {
            display: inline-block;
            padding: 9px 14px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back {
            background: #6b7280;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .warning {
            background: #fef3c7;
            color: #92400e;
        }

        .danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .muted {
            color: #6b7280;
        }
    </style>
</head>

<body>

<div class="container">

    {{-- Tombol kembali --}}
    <div style="margin-bottom: 20px;">

        <a
            href="{{ url()->previous() }}"
            class="button back"
        >
            ← Kembali
        </a>

    </div>


    {{-- DATA UTAMA PESERTA --}}
    <div class="card">

        <h1>
            {{ $peserta->nama }}
        </h1>

        <div class="grid">

            <div class="item">
                <div class="label">
                    No Kartu
                </div>

                <div class="value">
                    {{ $peserta->noka }}
                </div>
            </div>

            <div class="item">
                <div class="label">
                    Status Aktif
                </div>

                <div class="value">
                    {{ $peserta->status_aktif ?? '-' }}
                </div>
            </div>

            <div class="item">
                <div class="label">
                    No HP
                </div>

                <div class="value">
                    {{ $peserta->no_hp ?? '-' }}
                </div>
            </div>

            <div class="item">
                <div class="label">
                    Email
                </div>

                <div class="value">
                    {{ $peserta->email ?? '-' }}
                </div>
            </div>

            <div class="item">
                <div class="label">
                    No Pendaftar
                </div>

                <div class="value">
                    {{ $peserta->nopendaftar ?? '-' }}
                </div>
            </div>

            <div class="item">
                <div class="label">
                    No Penghubung
                </div>

                <div class="value">
                    {{ $peserta->nopenghubung ?? '-' }}
                </div>
            </div>

            <div class="item">
                <div class="label">
                    Alamat
                </div>

                <div class="value">
                    {{ $peserta->alamat ?? '-' }}
                </div>
            </div>

        </div>

    </div>


    {{-- STATUS TERAKHIR --}}
    <div class="card">

        <h2>
            Status Terakhir
        </h2>

        @if($verifikasiTerakhir)

            @php
                $service = app(\App\Services\PesertaStatusService::class);
                $status = $service->tentukan($peserta);
                $periode = $service->periodeTagihan();
            @endphp

            <div
                class="item {{ $status['tipe'] }}"
                style="margin-bottom: 15px;"
            >

                <div class="label">
                    Status Peserta
                </div>

                <div class="value">
                    {{ $status['label'] }}
                </div>

            </div>

            <div class="grid">

                <div class="item">

                    <div class="label">
                        Tanggal Cek
                    </div>

                    <div class="value">
                        {{ $verifikasiTerakhir->tanggal_cek?->format('d-m-Y') ?? '-' }}
                    </div>

                </div>

                <div class="item">

                    <div class="label">
                        Terdaftar REHAB
                    </div>

                    <div class="value">
                        {{ $verifikasiTerakhir->terdaftar_rehab ? 'Ya' : 'Tidak' }}
                    </div>

                </div>

                <div class="item">

                    <div class="label">
                        Tanggal Daftar REHAB
                    </div>

                    <div class="value">
                        {{ $verifikasiTerakhir->tanggal_daftar_rehab?->format('d-m-Y') ?? '-' }}
                    </div>

                </div>

                <div class="item">

                    <div class="label">
                        Jumlah Peserta di SIPP
                    </div>

                    <div class="value">
                        {{ $verifikasiTerakhir->jumlah_peserta_sipp ?? '-' }}
                    </div>

                </div>

                <div class="item">

                    <div class="label">
                        {{ $periode['bulan_sebelumnya'] }}
                    </div>

                    <div class="value">
                        Rp {{ number_format($verifikasiTerakhir->tagihan_sebelum_bulan_berjalan ?? 0, 0, ',', '.') }}
                    </div>

                </div>

                <div class="item">

                    <div class="label">
                        {{ $periode['bulan_berjalan'] }}
                    </div>

                    <div class="value">
                        Rp {{ number_format($verifikasiTerakhir->tagihan_bulan_berjalan ?? 0, 0, ',', '.') }}
                    </div>

                </div>

            </div>

        @else

            <p class="muted">
                Peserta belum pernah diverifikasi melalui SIPP.
            </p>

            <a
                href="{{ route('verifikasi-sipp.create', $peserta) }}"
                class="button"
            >
                Verifikasi SIPP
            </a>

        @endif

    </div>


    {{-- RIWAYAT VERIFIKASI --}}
    <div class="card">

        <h2>
            Riwayat Verifikasi SIPP
        </h2>

        @if($peserta->verifikasiSipp->count())

            <table>

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Tanggal Cek</th>
                        <th>REHAB</th>
                        <th>Peserta SIPP</th>
                        <th>{{ $periode['bulan_sebelumnya'] ?? 'Bulan Sebelumnya' }}</th>
                        <th>{{ $periode['bulan_berjalan'] ?? 'Bulan Berjalan' }}</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($peserta->verifikasiSipp as $verifikasi)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $verifikasi->tanggal_cek?->format('d-m-Y') ?? '-' }}
                            </td>

                            <td>
                                {{ $verifikasi->terdaftar_rehab ? 'Ya' : 'Tidak' }}
                            </td>

                            <td>
                                {{ $verifikasi->jumlah_peserta_sipp ?? '-' }}
                            </td>

                            <td>
                                Rp
                                {{ number_format($verifikasi->tagihan_sebelum_bulan_berjalan ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp
                                {{ number_format($verifikasi->tagihan_bulan_berjalan ?? 0, 0, ',', '.') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p class="muted">
                Belum ada riwayat verifikasi.
            </p>

        @endif

    </div>


    {{-- TOMBOL AKSI --}}
    <div class="card">

        <h2>
            Aksi
        </h2>

        <a
            href="{{ route('verifikasi-sipp.create', $peserta) }}"
            class="button"
        >
            Verifikasi SIPP
        </a>

    </div>

</div>

</body>
</html>