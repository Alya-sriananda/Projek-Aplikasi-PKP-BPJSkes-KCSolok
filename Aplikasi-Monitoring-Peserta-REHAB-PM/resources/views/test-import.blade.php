<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Test Import Excel</title>
</head>
<body>

    <h1>Test Import Excel</h1>

    <form
        action="/test-import"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <input
            type="file"
            name="file"
            accept=".xlsx,.xls,.csv"
            required
        >

        <button type="submit">
            Upload Excel
        </button>
    </form>

</body>
</html>