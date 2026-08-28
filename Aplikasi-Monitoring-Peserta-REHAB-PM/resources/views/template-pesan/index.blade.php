<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Template WhatsApp
</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 40px;
        background: #f5f6f8;
    }

    .container {
        max-width: 1100px;
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

    .success {
        background: #dcfce7;
        color: #166534;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .aktif {
        color: #166534;
        font-weight: bold;
    }

    .nonaktif {
        color: #991b1b;
        font-weight: bold;
    }
</style>

</head>

<body>

<div class="container">

@if(session('success'))

    <div class="success">
        {{ session('success') }}
    </div>

@endif


<div class="card">

    <h1>
        Template WhatsApp
    </h1>

    <a
        href="{{ route('template-pesan.create') }}"
        class="button"
    >
        + Buat Template
    </a>

</div>


<div class="card">

    @if($templates->count())

        <table>

            <thead>

                <tr>
                    <th>No</th>
                    <th>Nama Template</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                </tr>

            </thead>


            <tbody>

                @foreach($templates as $template)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $template->nama_template }}
                        </td>

                        <td>

                            @if($template->aktif)

                                <span class="aktif">
                                    Aktif
                                </span>

                            @else

                                <span class="nonaktif">
                                    Tidak Aktif
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $template->created_at->format('d-m-Y H:i') }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @else

        <p>
            Belum ada template WhatsApp.
        </p>

    @endif

</div>

</div>
</body>
</html>
