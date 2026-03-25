<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;

class ProductController extends Controller
{
    public function index() {
        $products = Product::with('image')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'producer' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'photo' => 'required|image|max:2048'
        ]);

        // 1. Upload Imagine
        $path = $request->file('photo')->store('products', 'public');
        $image = Image::create(['path' => $path]);

        // 2. Creare Produs cu datele primite
        Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'producer' => $data['producer'],
            'rating' => $data['rating'],
            'image_id' => $image->id
        ]);

        return back()->with('success', 'Produsul a fost adăugat cu succes!');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        
        // Ștergem și imaginea fizică dacă vrei curățenie completă
        if($product->image) {
            Storage::disk('public')->delete($product->image->path);
            $product->image->delete();
        }
        
        $product->delete();
        return back()->with('success', 'Produs șters!');
    }

    public function edit($id) {
        $product = Product::with('image')->findOrFail($id);
        return view('products.edit', compact('product'));
    }
    
    // Salvează modificările
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'producer' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'photo' => 'nullable|image|max:2048' // Imaginea este opțională la editare
        ]);
    
        // Dacă utilizatorul a încărcat o imagine nouă
        if ($request->hasFile('photo')) {
            // Ștergem imaginea veche de pe disc
            if($product->image) {
                Storage::disk('public')->delete($product->image->path);
            }
    
            // Upload imagine nouă
            $path = $request->file('photo')->store('products', 'public');
            
            // Actualizăm calea în tabelul images
            $product->image->update(['path' => $path]);
        }
    
        // Actualizăm datele produsului
        $product->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'producer' => $data['producer'],
            'rating' => $data['rating']
        ]);
    
        return redirect('/')->with('success', 'Produs actualizat cu succes!');
    }
}
