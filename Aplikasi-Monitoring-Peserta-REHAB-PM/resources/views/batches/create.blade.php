<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Import Data Peserta REHAB</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 12px 20px;
            cursor: pointer;
        }

        .success {
            background: #d1fae5;
            padding: 15px;
            margin-bottom: 20px;
        }

        .error {
            background: #fee2e2;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="card">

        <h1>Import Data Peserta REHAB</h1>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error">
                <strong>Terjadi kesalahan:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('batches.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="form-group">
                <label for="tanggal_data">
                    Tanggal Data
                </label>

                <input
                    type="date"
                    id="tanggal_data"
                    name="tanggal_data"
                    value="{{ old('tanggal_data') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="file">
                    File Excel
                </label>

                <input
                    type="file"
                    id="file"
                    name="file"
                    accept=".xlsx,.xls,.csv"
                    required
                >
            </div>

            <button type="submit">
                Import Excel
            </button>

        </form>

    </div>

</body>
</html>