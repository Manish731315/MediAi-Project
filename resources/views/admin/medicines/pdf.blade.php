<!DOCTYPE html>
<html>
<head>
    <title>Medicines PDF</title>
    <style>
        body { font-family: DejaVu Sans; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

    <h2>Medicines List</h2>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Prescription</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicines as $medicine)
                <tr>
                    <td>{{ $medicine->name }}</td>
                    <td>{{ $medicine->category->name ?? 'N/A' }}</td>
                    <td>₹{{ $medicine->price }}</td>
                    <td>{{ $medicine->stock }}</td>
                    <td>
                        {{ $medicine->prescription_required ? 'Yes' : 'No' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>