<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Hubungi Peserta - {{ $peserta->nama }}
    </title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f6f8;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .info {
            background: #eff6ff;
            padding: 15px;
            border-radius: 6px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 220px;
            resize: vertical;
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
            margin-right: 5px;
        }

        .button-secondary {
            background: #6b7280;
        }

        .button-success {
            background: #16a34a;
        }

        .button-whatsapp {
            background: #22c55e;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
        }

        .copy-group {
            display: flex;
            gap: 10px;
        }

        .copy-group input {
            flex: 1;
        }

    </style>

</head>

<body>

<div class="container">


    {{-- =========================
         TOMBOL KEMBALI
    ========================== --}}

    <div style="margin-bottom: 20px;">

        <a
            href="{{ route('tindak-lanjut.index') }}"
            class="button button-secondary"
        >
            ← Kembali
        </a>

    </div>


    {{-- =========================
         INFORMASI PESERTA
    ========================== --}}

    <div class="card">

        <h1>
            Hubungi Peserta
        </h1>

        <div class="info">

            <p>

                <strong>No Kartu:</strong>

                {{ $peserta->noka }}

            </p>

            <p>

                <strong>Nama:</strong>

                {{ $peserta->nama }}

            </p>

            <p>

                <strong>No HP:</strong>

                {{ $peserta->no_hp ?? '-' }}

            </p>

            <p>

                <strong>Email:</strong>

                {{ $peserta->email ?? '-' }}

            </p>

        </div>

    </div>


    {{-- =========================
         FORM KOMUNIKASI
    ========================== --}}

    <div class="card">

        <form
            method="POST"
            action="{{ route('komunikasi.store', $peserta) }}"
        >

            @csrf


            {{-- =====================
                 NOMOR WHATSAPP
            ====================== --}}

            <div class="form-group">

                <label for="no_hp">

                    Nomor WhatsApp

                </label>

                <div class="copy-group">

                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        value="{{ old('no_hp', $peserta->no_hp) }}"
                        required
                    >

                    <button
                        type="button"
                        class="button button-secondary"
                        onclick="copyNomor()"
                    >

                        Copy

                    </button>

                </div>

            </div>


            {{-- =====================
                 PILIH TEMPLATE
            ====================== --}}

            <div class="form-group">

                <label for="template_id">

                    Pilih Template Pesan

                </label>

                <select
                    id="template_id"
                >

                    <option value="">

                        -- Pilih Template --

                    </option>


                    @foreach($templates as $template)

                        <option
                            value="{{ $template->id }}"
                            data-nama="{{ $template->nama }}"
                            data-isi="{{ e($template->isi_pesan) }}"
                        >

                            {{ $template->nama }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- =====================
                 NAMA TEMPLATE
            ====================== --}}

            <input
                type="hidden"
                id="template"
                name="template"
            >


            {{-- =====================
                 ISI PESAN
            ====================== --}}

            <div class="form-group">

                <label for="pesan">

                    Pesan WhatsApp

                </label>

                <textarea
                    id="pesan"
                    name="pesan"
                    required
                >{{ old('pesan') }}</textarea>

            </div>


            <button
                type="button"
                class="button button-secondary"
                onclick="copyPesan()"
            >

                Copy Pesan

            </button>


            <button
                type="button"
                class="button button-whatsapp"
                onclick="bukaWhatsApp()"
            >

                Buka WhatsApp

            </button>


            <hr style="margin: 25px 0;">


            {{-- =====================
                 STATUS
            ====================== --}}

            <div class="form-group">

                <label for="status">

                    Status Komunikasi

                </label>

                <select
                    id="status"
                    name="status"
                    required
                >

                    <option value="">

                        -- Pilih Status --

                    </option>

                    <option
                        value="sudah_dihubungi"
                        {{ old('status') === 'sudah_dihubungi'
                            ? 'selected'
                            : ''
                        }}
                    >

                        Sudah Dihubungi

                    </option>

                    <option
                        value="gagal"
                        {{ old('status') === 'gagal'
                            ? 'selected'
                            : ''
                        }}
                    >

                        Gagal Dihubungi

                    </option>

                </select>

            </div>


            {{-- =====================
                 TANGGAL
            ====================== --}}

            <div class="form-group">

                <label for="tanggal_dihubungi">

                    Tanggal Dihubungi

                </label>

                <input
                    type="date"
                    id="tanggal_dihubungi"
                    name="tanggal_dihubungi"
                    value="{{ old(
                        'tanggal_dihubungi',
                        now()->format('Y-m-d')
                    ) }}"
                    required
                >

            </div>


            {{-- =====================
                 CATATAN
            ====================== --}}

            <div class="form-group">

                <label for="catatan">

                    Catatan

                </label>

                <textarea
                    id="catatan"
                    name="catatan"
                    style="min-height: 100px;"
                    placeholder="Contoh: Peserta tidak merespons..."
                >{{ old('catatan') }}</textarea>

            </div>


            {{-- =====================
                 SIMPAN
            ====================== --}}

            <button
                type="submit"
                class="button button-success"
            >

                Simpan Komunikasi

            </button>

        </form>

    </div>

</div>


<script>


    /*
    |--------------------------------------------------------------------------
    | DATA PESERTA
    |--------------------------------------------------------------------------
    */

    const peserta = {

        nama: @json($peserta->nama),

        noka: @json($peserta->noka),

        no_hp: @json($peserta->no_hp),

        email: @json($peserta->email),

    };


    /*
    |--------------------------------------------------------------------------
    | FORMAT RUPIAH
    |--------------------------------------------------------------------------
    */

    function formatRupiah(nilai) {

        if (!nilai) {
            return 'Rp0';
        }

        return new Intl.NumberFormat(
            'id-ID',
            {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }
        ).format(nilai);

    }


    /*
    |--------------------------------------------------------------------------
    | PILIH TEMPLATE
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('template_id')
        .addEventListener(
            'change',
            function () {

                const selected =
                    this.options[this.selectedIndex];


                if (!selected.value) {

                    document
                        .getElementById('pesan')
                        .value = '';

                    document
                        .getElementById('template')
                        .value = '';

                    return;

                }


                let isiPesan =
                    selected.dataset.isi;


                /*
                |--------------------------------------------------------------------------
                | GANTI VARIABEL DASAR
                |--------------------------------------------------------------------------
                */

                isiPesan =
                    isiPesan
                        .replaceAll(
                            '{nama}',
                            peserta.nama ?? ''
                        )
                        .replaceAll(
                            '{noka}',
                            peserta.noka ?? ''
                        )
                        .replaceAll(
                            '{no_hp}',
                            peserta.no_hp ?? ''
                        )
                        .replaceAll(
                            '{email}',
                            peserta.email ?? ''
                        );


                /*
                |--------------------------------------------------------------------------
                | MASUKKAN KE TEXTAREA
                |--------------------------------------------------------------------------
                */

                document
                    .getElementById('pesan')
                    .value = isiPesan;


                /*
                |--------------------------------------------------------------------------
                | SIMPAN NAMA TEMPLATE
                |--------------------------------------------------------------------------
                */

                document
                    .getElementById('template')
                    .value =
                    selected.dataset.nama;

            }
        );


    /*
    |--------------------------------------------------------------------------
    | COPY NOMOR
    |--------------------------------------------------------------------------
    */

    function copyNomor() {

        const nomor =
            document.getElementById('no_hp');

        navigator.clipboard
            .writeText(nomor.value)
            .then(() => {

                alert('Nomor berhasil disalin.');

            });

    }


    /*
    |--------------------------------------------------------------------------
    | COPY PESAN
    |--------------------------------------------------------------------------
    */

    function copyPesan() {

        const pesan =
            document.getElementById('pesan');

        navigator.clipboard
            .writeText(pesan.value)
            .then(() => {

                alert('Pesan berhasil disalin.');

            });

    }


    /*
    |--------------------------------------------------------------------------
    | BUKA WHATSAPP
    |--------------------------------------------------------------------------
    */

    function bukaWhatsApp() {

        let nomor =
            document
                .getElementById('no_hp')
                .value;


        let pesan =
            document
                .getElementById('pesan')
                .value;


        /*
         * Bersihkan karakter selain angka.
         */
        nomor =
            nomor.replace(/\D/g, '');


        /*
         * Konversi nomor Indonesia.
         */
        if (nomor.startsWith('0')) {

            nomor =
                '62' +
                nomor.substring(1);

        }


        if (!nomor) {

            alert('Nomor WhatsApp belum tersedia.');

            return;

        }


        const url =
            'https://wa.me/' +
            nomor +
            '?text=' +
            encodeURIComponent(pesan);


        window.open(
            url,
            '_blank'
        );

    }


</script>

</body>

</html>