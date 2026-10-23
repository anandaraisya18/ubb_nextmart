<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\ManagementGroup;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    // Beranda pelanggan
    public function dashboard()
    {
        $produkTerbaru = Produk::aktif()
            ->with(['kategori', 'toko'])
            ->where('stok', '>', 0)
            ->latest('id_produk')
            ->limit(8)
            ->get();

        $jumlahPerToko = DB::table('produk')
            ->where('status', 'aktif')
            ->select('id_toko', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('id_toko')
            ->pluck('jumlah', 'id_toko');

        $tokoList = DB::table('toko')->get()->map(function ($toko) use ($jumlahPerToko) {
            $toko->produk_count = $jumlahPerToko[$toko->id_toko] ?? 0;
            return $toko;
        });

        return view('pelanggan.dashboard.index', [
            'produkTerbaru' => $produkTerbaru,
            'kategoriList'  => Kategori::orderBy('nama_kategori')->get(),
            'tokoList'      => $tokoList,
            'groups'        => ManagementGroup::all(),
        ]);
    }

    // Halaman pemilihan grup toko
    public function pilihGroup()
    {
        $groups = ManagementGroup::all();

        return view('pelanggan.produk.pilih-group', compact('groups'));
    }

    // Katalog produk berdasarkan grup yang dipilih
    public function index(Request $request)
    {
        // Tanpa grup dan tanpa pencarian: tampilkan halaman pilih grup dulu
        if (! $request->filled('group') && ! $request->filled('q')) {
            return $this->pilihGroup();
        }

        $kategori      = Kategori::orderBy('nama_kategori')->get();
        $groups        = ManagementGroup::all();
        $selectedGroup = null;

        $query = Produk::aktif()->with(['kategori', 'toko']);

        if ($request->filled('group')) {
            $selectedGroup = ManagementGroup::findOrFail($request->input('group'));

            // Hanya produk dari toko dalam grup yang dipilih
            $query->whereHas('toko', fn ($q) => $q->where('id_group', $selectedGroup->id_group));
        }

        if ($request->filled('q')) {
            $q = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $request->input('q'));
            $query->where('nama_produk', 'like', "%{$q}%");
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->input('kategori'));
        }

        $produk = $query
            ->latest('id_produk')
            ->paginate(12)
            ->withQueryString();

        return view('pelanggan.produk.index', compact(
            'produk',
            'kategori',
            'groups',
            'selectedGroup'
        ));
    }

    public function show(Produk $produk)
    {
        abort_if($produk->status !== 'aktif', 404);

        $produk->load(['kategori', 'toko']);

        return view('pelanggan.produk.show', compact('produk'));
    }
}