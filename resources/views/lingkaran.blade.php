<!DOCTYPE html>
<html>
<head>
    <title>Hitung Luas Segitiga</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">Menghitung Luas Lingkaran</h2>

    <form action="{{ route('lingkaran.hitung') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Jari-Jari</label>
            <input type="number" name="jari_jari" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Hitung
        </button>
    </form>

    <hr>

    @if(count($data) > 0)
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Jari-Jari</th>
                <th>Luas Lingkaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['jari_jari'] }}</td>
                <td>{{ $item['luas'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</div>

</body>
</html>