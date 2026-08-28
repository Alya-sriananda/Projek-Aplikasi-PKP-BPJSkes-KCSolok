<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Buat Template WhatsApp
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
        border-radius: 8px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
    }

    input,
    textarea {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    textarea {
        min-height: 300px;
        resize: vertical;
    }

    .button {
        display: inline-block;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        background: #2563eb;
        color: white;
    }

    .back {
        background: #6b7280;
    }

    .error {
        color: #dc2626;
        margin-top: 5px;
    }

    .variables {
        background: #eff6ff;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    code {
        background: #e5e7eb;
        padding: 3px 6px;
        border-radius: 4px;
    }
</style>

</head>

<body>

<div class="container">

<div style="margin-bottom: 20px;">

    <a
        href="{{ route('template-pesan.index') }}"
        class="button back"
    >
        ← Kembali
    </a>

</div>


<div class="card">

    <h1>
        Buat Template WhatsApp
    </h1>


    <div class="variables">

        <strong>
            Variabel yang tersedia
        </strong>

        <p>
            <code>{nama}</code>
            Nama peserta
        </p>

        <p>
            <code>{noka}</code>
            Nomor kartu
        </p>

        <p>
            <code>{no_hp}</code>
            Nomor HP
        </p>

        <p>
            <code>{email}</code>
            Email peserta
        </p>

        <p>
            <code>{tanggal_daftar_rehab}</code>
            Tanggal pendaftaran rehab
        </p>

        <p>
            <code>{jumlah_peserta_sipp}</code>
            Jumlah peserta SIPP
        </p>

        <p>
            <code>{bulan_sebelumnya}</code>
            Bulan sebelumnya
        </p>

        <p>
            <code>{bulan_berjalan}</code>
            Bulan berjalan
        </p>

        <p>
            <code>{tagihan_sebelumnya}</code>
            Tagihan bulan sebelumnya
        </p>

        <p>
            <code>{tagihan_berjalan}</code>
            Tagihan bulan berjalan
        </p>
        <p>
            <code>{total_tagihan}</code>
            Total tagihan
        </p>

    </div>


    @if($errors->any())

        <div
            style="
                background: #fee2e2;
                padding: 15px;
                border-radius: 6px;
                margin-bottom: 20px;
            "
        >

            <strong>
                Terdapat kesalahan:
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('template-pesan.store') }}"
    >

        @csrf


        <div class="form-group">

            <label for="nama_template">
                Nama Template
            </label>

            <input
                type="text"
                id="nama_template"
                name="nama_template"
                value="{{ old('nama_template') }}"
                placeholder="Contoh: Pengingat Pembayaran REHAB"
                required
            >

        </div>


        <div class="form-group">

            <label for="isi_template">
                Isi Pesan
            </label>

            <textarea
                id="isi_template"
                name="isi_template"
                placeholder="Tulis template WhatsApp di sini..."
                required
            >{{ old('isi_template') }}</textarea>

        </div>


        <div class="form-group">

            <label>

                <input
                    type="checkbox"
                    name="aktif"
                    value="1"
                    {{ old('aktif', true) ? 'checked' : '' }}
                    style="width: auto;"
                >

                Aktifkan template

            </label>

        </div>


        <button
            type="submit"
            class="button"
        >
            Simpan Template
        </button>

    </form>

</div>
</div>
</body>
</html>