<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Hasil Verifikasi - {{ $peserta->nama }}
    </title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f6f8;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .status {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 18px;
        }

        .status-green {
            background: #dcfce7;
            color: #166534;
        }

        .status-red {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-yellow {
            background: #fef9c3;
            color: #854d0e;
        }

        .status-orange {
            background: #ffedd5;
            color: #9a3412;
        }

        .status-gray {
            background: #e5e7eb;
            color: #374151;
        }

        .info-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .info-label {
            width: 250px;
            font-weight: bold;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button-back {
            background: #6b7280;
        }

        textarea {
            width: 100%;
            min-height: 250px;
            padding: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: Arial, sans-serif;
            line-height: 1.5;
            resize: vertical;
        }

        .small {
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="container">

    <div style="margin-bottom: 20px;">
        <a
            href="{{ route('batches.index') }}"
            class="button button-back"
        >
            ← Kembali
        </a>
    </div>

    {{-- INFORMASI PESERTA --}}
    <div class="card">

        <h1>
            Hasil Verifikasi SIPP
        </h1>

        <div class="info-row">
            <div class="info-label">
                No Kartu
            </div>

            <div>
                {{ $peserta->noka }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">
                Nama
            </div>

            <div>
                {{ $peserta->nama }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">
                No HP
            </div>

            <div>
                {{ $peserta->no_hp ?? '-' }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">
                Email
            </div>

            <div>
                {{ $peserta->email ?? '-' }}
            </div>
        </div>

    </div>


    {{-- STATUS --}}
    <div class="card">

        <h2>
            Status Peserta
        </h2>

        <div class="status status-{{ $hasilStatus['warna'] }}">

            {{ $hasilStatus['label'] }}

        </div>

        <p>
            {{ $hasilStatus['keterangan'] }}
        </p>

    </div>


    {{-- DATA VERIFIKASI --}}
    @if($hasilStatus['verifikasi'])

        <div class="card">

            <h2>
                Data Verifikasi
            </h2>

            <div class="info-row">

                <div class="info-label">
                    Tanggal Cek
                </div>

                <div>
                    {{ $hasilStatus['verifikasi']->tanggal_cek?->format('d-m-Y') }}
                </div>

            </div>

            <div class="info-row">

                <div class="info-label">
                    Terdaftar REHAB
                </div>

                <div>
                    {{ $hasilStatus['verifikasi']->terdaftar_rehab ? 'Ya' : 'Tidak' }}
                </div>

            </div>

            @if($hasilStatus['verifikasi']->terdaftar_rehab)

                <div class="info-row">

                    <div class="info-label">
                        Tanggal Daftar REHAB
                    </div>

                    <div>
                        {{ $hasilStatus['verifikasi']->tanggal_daftar_rehab?->format('d-m-Y') ?? '-' }}
                    </div>

                </div>

                <div class="info-row">

                    <div class="info-label">
                        Jumlah Peserta di SIPP
                    </div>

                    <div>
                        {{ $hasilStatus['verifikasi']->jumlah_peserta_sipp ?? '-' }}
                    </div>

                </div>

                <div class="info-row">

                    <div class="info-label">
                        Tagihan {{ $bulanSekarang }}
                    </div>

                    <div>
                        Rp
                        {{ number_format(
                            (float) ($hasilStatus['verifikasi']->tagihan_bulan_berjalan ?? 0),
                            0,
                            ',',
                            '.'
                        ) }}
                    </div>

                </div>

                <div class="info-row">

                    <div class="info-label">
                        Tunggakan Sebelum {{ $bulanSekarang }}
                    </div>

                    <div>
                        Rp
                        {{ number_format(
                            (float) ($hasilStatus['verifikasi']->tagihan_sebelum_bulan_berjalan ?? 0),
                            0,
                            ',',
                            '.'
                        ) }}
                    </div>

                </div>

                <div class="info-row">

                    <div class="info-label">
                        Status Pembayaran {{ $bulanSekarang }}
                    </div>

                    <div>
                        @if($hasilStatus['verifikasi']->status_pembayaran_bulan_berjalan === 'belum_bayar')
                            Belum Bayar
                        @elseif($hasilStatus['verifikasi']->status_pembayaran_bulan_berjalan === 'sudah_bayar')
                            Sudah Bayar
                        @else
                            -
                        @endif
                    </div>

                </div>

            @endif

        </div>

    @endif


    {{-- WHATSAPP --}}
    @if($pesanWhatsApp)

        <div class="card">

            <h2>
                Template WhatsApp
            </h2>

            <p class="small">
                Pesan dibuat otomatis berdasarkan status hasil verifikasi.
            </p>

            <textarea
                id="pesan-whatsapp"
                readonly
            >{{ $pesanWhatsApp }}</textarea>

            <br>
            <br>

            <button
                type="button"
                class="button"
                onclick="copyWhatsApp()"
            >
                📋 Copy Pesan WhatsApp
            </button>

        </div>

    @endif

</div>


<script>

function copyWhatsApp()
{
    const textarea = document.getElementById('pesan-whatsapp');

    navigator.clipboard.writeText(textarea.value)
        .then(function () {

            alert('Pesan WhatsApp berhasil disalin.');

        })
        .catch(function () {

            textarea.select();
            document.execCommand('copy');

            alert('Pesan WhatsApp berhasil disalin.');

        });
}

</script>

</body>

</html>