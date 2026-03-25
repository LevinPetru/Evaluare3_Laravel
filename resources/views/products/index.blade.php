<!DOCTYPE html>
<html>
<head>
    <title>Gestiune Produse</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">### Adaugă Produs Nou</div>
        <div class="card-body">
            <form action="/products" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nume Produs</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Preț (RON)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Cantitate</label>
                        <input type="number" name="quantity" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Producător</label>
                        <input type="text" name="producer" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Nota (1-5)</label>
                        <select name="rating" class="form-control">
                            @for($i=1; $i<=5; $i++) <option value="{{$i}}">{{$i}} Stele</option> @endfor
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Imagine Produs</label>
                        <input type="file" name="photo" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Salvează Produsul</button>
            </form>
        </div>
    </div>

    <h3>Lista Produse</h3>
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagine</th>
                <th>Nume</th>
                <th>Detalii</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>
                    @if($p->image)
                        <img src="{{ asset('storage/' . $p->image->path) }}" width="80" class="rounded shadow-sm">
                    @else
                        <span>Fără imagine</span>
                    @endif
                </td>
                <td><strong>{{ $p->name }}</strong></td>
                <td>
                    <small>
                        Producător: {{ $p->producer }}<br>
                        Preț: {{ $p->price }} RON | Stoc: {{ $p->quantity }}<br>
                        Rating: {{ $p->rating }}/5 ⭐
                    </small>
                </td>
                <td>
    <div class="d-flex gap-2">
        <a href="/products/{{ $p->id }}/edit" class="btn btn-sm btn-warning">Editează</a>

        <form action="/products/{{ $p->id }}" method="POST" onsubmit="return confirm('Ștergi produsul?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Șterge</button>
        </form>
    </div>
</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>