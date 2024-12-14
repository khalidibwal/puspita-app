<!DOCTYPE html>
<html>
<head>
    <title>PDF Export</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1>My PDF Document</h1>
    <p>This is a sample PDF export.</p>
    <table>
        <thead>
            <tr>
                <th>nip</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->namaDokter }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
