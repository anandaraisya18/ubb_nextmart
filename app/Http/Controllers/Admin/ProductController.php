<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Produk::with('toko')->latest()->paginate(10);

        $totalProduk    = Produk::count();
        $produkTersedia = Produk::aktif()->where('stok', '>', 0)->count();
        $stokHabis      = Produk::where('stok', '<=', 0)->count();

        return view('admin.products.index', compact(
            'products', 'totalProduk', 'produkTersedia', 'stokHabis'
        ));
    }

    public function create()
    {
        return view('admin.products.create', [
            'kategori' => Kategori::orderBy('nama_kategori')->get(),
            'toko'     => Toko::orderBy('nama_toko')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $product)
    {
        $product->load(['kategori', 'toko']);
        return view('admin.products.show', ['product' => $product]);
    }

    public function edit(Produk $product)
    {
        return view('admin.products.edit', [
            'product'  => $product,
            'kategori' => Kategori::orderBy('nama_kategori')->get(),
            'toko'     => Toko::orderBy('nama_toko')->get(),
        ]);
    }

    public function update(Request $request, Produk $product)
    {
        $data = $this->validated($request);

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $product)
    {
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama_produk' => ['required', 'string', 'max:150'],
            'id_kategori' => ['required', 'exists:kategori,id_kategori'],
            'id_toko'     => ['required', 'exists:toko,id_toko'],
            'harga'       => ['required', 'integer', 'min:0'],
            'stok'        => ['required', 'integer', 'min:0'],
            'status'      => ['required', 'in:aktif,nonaktif'],
            'deskripsi'   => ['nullable', 'string'],
            'gambar'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}