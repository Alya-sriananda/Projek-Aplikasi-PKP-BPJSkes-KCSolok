<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Verifikasi SIPP - {{ $peserta->nama }}
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
            min-height: 100px;
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

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
        }

        .info {
            background: #eff6ff;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<div class="container">

    <div style="margin-bottom: 20px;">

        <a
            href="{{ url()->previous() }}"
            class="button button-back"
        >
            ← Kembali
        </a>

    </div>


    <div class="card">

        <h1>
            Verifikasi SIPP
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


        @if($errors->any())

            <div
                class="card"
                style="background: #fee2e2;"
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
            action="{{ route('verifikasi-sipp.store', $peserta) }}"
        >

            @csrf


            <div class="form-group">

                <label for="tanggal_cek">
                    Tanggal Cek SIPP
                </label>

                <input
                    type="date"
                    id="tanggal_cek"
                    name="tanggal_cek"
                    value="{{ old('tanggal_cek', now()->format('Y-m-d')) }}"
                    required
                >

                @error('tanggal_cek')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="terdaftar_rehab">
                    Terdaftar REHAB?
                </label>

                <select
                    id="terdaftar_rehab"
                    name="terdaftar_rehab"
                    required
                >

                    <option value="">
                        -- Pilih --
                    </option>

                    <option
                        value="1"
                        {{ old('terdaftar_rehab') === '1' ? 'selected' : '' }}
                    >
                        Ya
                    </option>

                    <option
                        value="0"
                        {{ old('terdaftar_rehab') === '0' ? 'selected' : '' }}
                    >
                        Tidak
                    </option>

                </select>

            </div>


            <div id="data-rehab">


                <div class="form-group">

                    <label for="tanggal_daftar_rehab">
                        Tanggal Daftar REHAB
                    </label>

                    <input
                        type="date"
                        id="tanggal_daftar_rehab"
                        name="tanggal_daftar_rehab"
                        value="{{ old('tanggal_daftar_rehab') }}"
                    >

                </div>


                <div class="form-group">

                    <label for="jumlah_peserta_sipp">
                        Jumlah Peserta di SIPP
                    </label>

                    <input
                        type="number"
                        id="jumlah_peserta_sipp"
                        name="jumlah_peserta_sipp"
                        min="1"
                        value="{{ old('jumlah_peserta_sipp') }}"
                    >

                </div>


                <div class="form-group">

                    <label for="tagihan_bulan_berjalan">
                        Tagihan Bulan Berjalan
                    </label>

                    <input
                        type="number"
                        id="tagihan_bulan_berjalan"
                        name="tagihan_bulan_berjalan"
                        min="0"
                        step="0.01"
                        value="{{ old('tagihan_bulan_berjalan') }}"
                        placeholder="Contoh: 210000"
                    >

                </div>


                <div class="form-group">

                    <label for="tagihan_sebelum_bulan_berjalan">
                        Tagihan Sebelum Bulan Berjalan
                    </label>

                    <input
                        type="number"
                        id="tagihan_sebelum_bulan_berjalan"
                        name="tagihan_sebelum_bulan_berjalan"
                        min="0"
                        step="0.01"
                        value="{{ old('tagihan_sebelum_bulan_berjalan', 0) }}"
                        placeholder="Contoh: 280000"
                    >

                </div>


                <div class="form-group">

                    <label for="status_pembayaran_bulan_berjalan">
                        Status Pembayaran Bulan Berjalan
                    </label>

                    <select
                        id="status_pembayaran_bulan_berjalan"
                        name="status_pembayaran_bulan_berjalan"
                    >

                        <option value="">
                            -- Pilih --
                        </option>

                        <option
                            value="belum_bayar"
                            {{ old('status_pembayaran_bulan_berjalan') === 'belum_bayar' ? 'selected' : '' }}
                        >
                            Belum Bayar
                        </option>

                        <option
                            value="sudah_bayar"
                            {{ old('status_pembayaran_bulan_berjalan') === 'sudah_bayar' ? 'selected' : '' }}
                        >
                            Sudah Bayar
                        </option>

                    </select>

                </div>

            </div>


            <div class="form-group">

                <label for="catatan">
                    Catatan
                </label>

                <textarea
                    id="catatan"
                    name="catatan"
                    placeholder="Catatan hasil pengecekan SIPP..."
                >{{ old('catatan') }}</textarea>

            </div>


            <button
                type="submit"
                class="button"
            >
                Simpan Verifikasi
            </button>

        </form>

    </div>

</div>


<script>

    const terdaftarRehab =
        document.getElementById('terdaftar_rehab');

    const dataRehab =
        document.getElementById('data-rehab');


    function toggleDataRehab()
    {
        if (terdaftarRehab.value === '1') {

            dataRehab.style.display = 'block';

        } else {

            dataRehab.style.display = 'none';

        }
    }


    terdaftarRehab.addEventListener(
        'change',
        toggleDataRehab
    );


    toggleDataRehab();

</script>

</body>

</html>