<!DOCTYPE html>
<html>
<head>
    <title>Editează Produs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="card">
        <div class="card-header">### Editează Produsul: {{ $product->name }}</div>
        <div class="card-body">
            <form action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nume Produs</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Preț</label>
                        <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Cantitate</label>
                        <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Producător</label>
                        <input type="text" name="producer" value="{{ $product->producer }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nota (1-5)</label>
                        <select name="rating" class="form-control">
                            @for($i=1; $i<=5; $i++)
                                <option value="{{$i}}" {{ $product->rating == $i ? 'selected' : '' }}>{{$i}} Stele</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Schimbă Imaginea (opțional)</label>
                        <input type="file" name="photo" class="form-control">
                        @if($product->image)
                            <p class="mt-2">Imagine curentă: <img src="{{ asset('storage/' . $product->image->path) }}" width="50"></p>
                        @endif
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Actualizează Produsul</button>
                <a href="/" class="btn btn-secondary">Anulează</a>
            </form>
        </div>
    </div>
</body>
</html>