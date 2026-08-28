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
            margin: 30px;
            background: #f5f6f8;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 22px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item {
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

        .badge {
            display: inline-block;
            padding: 6px 10px;
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
            padding: 9px 13px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }

        .button-primary {
            background: #2563eb;
            color: white;
        }

        .button-secondary {
            background: #6b7280;
            color: white;
        }

        .button-success {
            background: #16a34a;
            color: white;
        }

        .button-email {
            background: #7c3aed;
            color: white;
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

        .amount {
            font-weight: bold;
        }

        .empty {
            color: #6b7280;
        }

        @media (max-width: 800px) {
            .info-grid {
                grid-template-columns: 1fr;
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
                    Detail Peserta
                </h1>

                <p>
                    {{ $peserta->nama }}
                </p>

            </div>

            <div>

                <a
                    href="{{ route('monitoring.index', $batch) }}"
                    class="button button-secondary"
                >
                    ← Kembali
                </a>

            </div>

        </div>

    </div>


    {{-- DATA PESERTA --}}
    <div class="card">

        <h2>
            Data Peserta
        </h2>

        <div class="info-grid">

            <div class="info-item">
                <div class="label">
                    No Kartu
                </div>

                <div class="value">
                    {{ $peserta->noka }}
                </div>
            </div>

            <div class="info-item">
                <div class="label">
                    Nama
                </div>

                <div class="value">
                    {{ $peserta->nama }}
                </div>
            </div>

            <div class="info-item">
                <div class="label">
                    No HP
                </div>

                <div class="value">
                    {{ $peserta->no_hp ?? '-' }}
                </div>
            </div>

            <div class="info-item">
                <div class="label">
                    Email
                </div>

                <div class="value">
                    {{ $peserta->email ?? '-' }}
                </div>
            </div>

            <div class="info-item">
                <div class="label">
                    Alamat
                </div>

                <div class="value">
                    {{ $peserta->alamat ?? '-' }}
                </div>
            </div>

            <div class="info-item">
                <div class="label">
                    Status Monitoring
                </div>

                <div>
                    <span
                        class="badge badge-{{ $peserta->status_monitoring['tipe'] }}"
                    >
                        {{ $peserta->status_monitoring['label'] }}
                    </span>
                </div>
            </div>

        </div>

    </div>


    {{-- TAGIHAN --}}
    <div class="card">

        <h2>
            Tagihan
        </h2>

        @php
            $verifikasi = $peserta->verifikasiTerakhir;

            $tagihanSebelumnya =
                $verifikasi?->tagihan_sebelum_bulan_berjalan ?? 0;

            $tagihanBerjalan =
                $verifikasi?->tagihan_bulan_berjalan ?? 0;
        @endphp

        <div class="info-grid">

            <div class="info-item">

                <div class="label">
                    {{ $periode['bulan_sebelumnya'] }}
                </div>

                <div class="value amount">
                    Rp{{ number_format(
                        $tagihanSebelumnya,
                        0,
                        ',',
                        '.'
                    ) }}
                </div>

            </div>

            <div class="info-item">

                <div class="label">
                    {{ $periode['bulan_berjalan'] }}
                </div>

                <div class="value amount">
                    Rp{{ number_format(
                        $tagihanBerjalan,
                        0,
                        ',',
                        '.'
                    ) }}
                </div>

            </div>

        </div>

    </div>


    {{-- VERIFIKASI TERAKHIR --}}
    <div class="card">

        <h2>
            Verifikasi SIPP Terakhir
        </h2>

        @if($verifikasi)

            <div class="info-grid">

                <div class="info-item">

                    <div class="label">
                        Tanggal Cek
                    </div>

                    <div class="value">
                        {{ $verifikasi->tanggal_cek?->format('d-m-Y') }}
                    </div>

                </div>

                <div class="info-item">

                    <div class="label">
                        Terdaftar REHAB
                    </div>

                    <div class="value">
                        {{ $verifikasi->terdaftar_rehab ? 'Ya' : 'Tidak' }}
                    </div>

                </div>

                <div class="info-item">

                    <div class="label">
                        Tanggal Daftar REHAB
                    </div>

                    <div class="value">
                        {{ $verifikasi->tanggal_daftar_rehab?->format('d-m-Y') ?? '-' }}
                    </div>

                </div>

                <div class="info-item">

                    <div class="label">
                        Jumlah Peserta di SIPP
                    </div>

                    <div class="value">
                        {{ $verifikasi->jumlah_peserta_sipp ?? '-' }}
                    </div>

                </div>

                <div class="info-item">

                    <div class="label">
                        Status Pembayaran
                    </div>

                    <div class="value">
                        {{ $verifikasi->status_pembayaran_bulan_berjalan
                            ? ucfirst(str_replace(
                                '_',
                                ' ',
                                $verifikasi->status_pembayaran_bulan_berjalan
                            ))
                            : '-'
                        }}
                    </div>

                </div>

                <div class="info-item">

                    <div class="label">
                        Catatan
                    </div>

                    <div class="value">
                        {{ $verifikasi->catatan ?? '-' }}
                    </div>

                </div>

            </div>

        @else

            <p class="empty">
                Peserta belum pernah diverifikasi melalui SIPP.
            </p>

        @endif

        <br>

        <a
            href="{{ route(
                'verifikasi-sipp.create',
                $peserta
            ) }}"
            class="button button-primary"
        >
            Verifikasi SIPP
        </a>

    </div>


    {{-- KELUARGA --}}
    <div class="card">

        <h2>
            Data Keluarga
        </h2>

        <p>
            Sistem mengelompokkan peserta berdasarkan
            <strong>nomor HP yang sama</strong>.
        </p>

        <p>
            Nomor HP keluarga:
            <strong>
                {{ $peserta->no_hp ?? '-' }}
            </strong>
        </p>

        @if($peserta->no_hp && $anggotaKeluarga->count())

            <table>

                <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        Nama
                    </th>

                    <th>
                        NOKA
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

                </thead>

                <tbody>

                {{-- Peserta utama --}}
                <tr>

                    <td>
                        1
                    </td>

                    <td>
                        <strong>
                            {{ $peserta->nama }}
                        </strong>
                    </td>

                    <td>
                        {{ $peserta->noka }}
                    </td>

                    <td>
                        {{ $peserta->email ?? '-' }}
                    </td>

                    <td>

                        <span
                            class="badge badge-{{ $peserta->status_monitoring['tipe'] }}"
                        >
                            {{ $peserta->status_monitoring['label'] }}
                        </span>

                    </td>

                    <td>
                        Peserta saat ini
                    </td>

                </tr>


                {{-- Anggota keluarga --}}
                @foreach($anggotaKeluarga as $index => $anggota)

                    <tr>

                        <td>
                            {{ $index + 2 }}
                        </td>

                        <td>
                            <strong>
                                {{ $anggota->nama }}
                            </strong>
                        </td>

                        <td>
                            {{ $anggota->noka }}
                        </td>

                        <td>
                            {{ $anggota->email ?? '-' }}
                        </td>

                        <td>

                            <span
                                class="badge badge-{{ $anggota->status_monitoring['tipe'] }}"
                            >
                                {{ $anggota->status_monitoring['label'] }}
                            </span>

                        </td>

                        <td>

                            <a
                                href="{{ route(
                                    'monitoring.show',
                                    [
                                        'batch' => $batch,
                                        'peserta' => $anggota->id,
                                    ]
                                ) }}"
                                class="button button-secondary"
                            >
                                Detail
                            </a>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        @elseif($peserta->no_hp)

            <p class="empty">
                Tidak ditemukan peserta lain dengan nomor HP yang sama.
            </p>

        @else

            <p class="empty">
                Nomor HP peserta belum tersedia sehingga
                keluarga tidak dapat dikelompokkan.
            </p>

        @endif

    </div>


    {{-- AKSI --}}
    <div class="card">

        <h2>
            Komunikasi
        </h2>

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

    </div>

</div>

</body>
</html>