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
        max-width: 1400px;
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
        vertical-align: middle;
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
        border: none;
        cursor: pointer;
    }

    .back {
        background: #6b7280;
    }

    .verify {
        background: #2563eb;
    }

    .whatsapp {
        background: #16a34a;
    }

    .status {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: bold;
    }

    .status-success {
        background: #dcfce7;
        color: #166534;
    }

    .status-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .status-info {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-secondary {
        background: #e5e7eb;
        color: #374151;
    }

    .muted {
        color: #6b7280;
    }

    .period-info {
        background: #eff6ff;
        padding: 15px;
        border-radius: 6px;
        margin-top: 15px;
    }

    .actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .money {
        white-space: nowrap;
    }
</style>

</head>

<body>

<div class="container">

{{-- Tombol kembali --}}
<div style="margin-bottom: 20px;">

    <a
        href="{{ route('batches.index') }}"
        class="button back"
    >
        ← Kembali
    </a>

</div>


{{-- Pesan sukses --}}
@if(session('success'))

    <div
        class="card"
        style="background: #dcfce7;"
    >
        {{ session('success') }}
    </div>

@endif


{{-- Informasi batch --}}
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

    @php
        $statusService = app(\App\Services\PesertaStatusService::class);
        $periode = $statusService->periodeTagihan();
    @endphp

    <div class="period-info">

        <strong>Periode Tagihan</strong>

        <div style="margin-top: 8px;">
            {{ $periode['bulan_sebelumnya'] }}
            →
            {{ $periode['bulan_berjalan'] }}
        </div>

    </div>

</div>


{{-- Daftar peserta --}}
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

                    <th>Status Otomatis</th>

                    <th>
                        {{ 'Tagihan ' . $periode['bulan_sebelumnya'] }}
                    </th>

                    <th>
                        {{ 'Tagihan ' . $periode['bulan_berjalan'] }}
                    </th>

                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

                @foreach($batch->pesertas as $peserta)

                    @php
                        $status = $statusService->tentukan($peserta);

                        $verifikasi = $peserta->verifikasiTerakhir;
                    @endphp

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


                        {{-- STATUS --}}
                        <td>

                            <span
                                class="status status-{{ $status['tipe'] }}"
                            >
                                {{ $status['label'] }}
                            </span>

                        </td>


                        {{-- TAGIHAN SEBELUMNYA --}}
                        <td class="money">

                            @if($verifikasi)

                                Rp
                                {{ number_format(
                                    $verifikasi->tagihan_sebelum_bulan_berjalan,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            @else

                                <span class="muted">
                                    Belum dicek
                                </span>

                            @endif

                        </td>


                        {{-- TAGIHAN BULAN BERJALAN --}}
                        <td class="money">

                            @if($verifikasi)

                                Rp
                                {{ number_format(
                                    $verifikasi->tagihan_bulan_berjalan,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            @else

                                <span class="muted">
                                    Belum dicek
                                </span>

                            @endif

                        </td>


                        {{-- AKSI --}}
                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route(
                                        'verifikasi-sipp.create',
                                        $peserta
                                    ) }}"
                                    class="button verify"
                                >
                                    Verifikasi
                                </a>


                                @if(
                                    $peserta->no_hp &&
                                    $verifikasi &&
                                    $status['kode'] === 'belum_bayar_bulan_berjalan'
                                )

                                    <a
                                        href="#"
                                        class="button whatsapp"
                                        onclick="alert('Generator WhatsApp akan kita aktifkan pada tahap berikutnya.')"
                                    >
                                        WhatsApp
                                    </a>

                                @endif

                            </div>

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