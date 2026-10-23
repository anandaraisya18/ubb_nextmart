<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\ManagementGroup;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class KeranjangController extends Controller
{
    private const CART     = 'keranjang';       // [id_produk => jumlah]
    private const CHECKOUT = 'checkout_items';  // [id_produk => jumlah]

    public function index()
    {
        $groups = $this->lines()
            ->groupBy('id_group')
            ->map(fn (Collection $items, $idGroup) => [
                'id_group'   => (int) $idGroup,
                'nama_group' => $items->first()['nama_group'],
                'items'      => $items->sortBy('id_toko')->values(),
            ])
            ->values();

        return view('pelanggan.keranjang.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_produk' => ['required', 'integer', 'exists:produk,id_produk'],
            'jumlah'    => ['nullable', 'integer', 'min:1', 'max:999'],
        ]);

        $produk = Produk::aktif()
            ->with('toko')
            ->where('id_produk', $data['id_produk'])
            ->first();

        if (! $produk) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        if ((int) $produk->stok < 1) {
            return back()->with('error', 'Stok produk habis.');
        }

        // Produk hanya bisa dibeli kalau grup tokonya aktif
        $idGroup = $produk->toko->id_group ?? null;

        $groupAktif = $idGroup
            && ManagementGroup::where('id_group', $idGroup)->where('status', 'aktif')->exists();

        if (! $groupAktif) {
            return back()->with('error', 'Produk ini belum bisa dibeli saat ini.');
        }

        $cart   = session(self::CART, []);
        $maks   = (int) $produk->stok;
        $baru   = ($cart[$produk->id_produk] ?? 0) + (int) ($data['jumlah'] ?? 1);

        $cart[$produk->id_produk] = min($baru, $maks);
        session([self::CART => $cart]);

        return back()->with(
            'success',
            $baru > $maks
                ? "Jumlah disesuaikan dengan stok tersedia ({$maks})."
                : $produk->nama_produk . ' ditambahkan ke keranjang.'
        );
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $cart = session(self::CART, []);

        if (! isset($cart[$id])) {
            return response()->json(['ok' => false], 404);
        }

        $stok = (int) Produk::where('id_produk', $id)->value('stok');

        $cart[$id] = max(1, min((int) $data['jumlah'], $stok ?: 1));
        session([self::CART => $cart]);

        return response()->json(['ok' => true, 'jumlah' => $cart[$id]]);
    }

    public function destroy(int $id)
    {
        $cart = session(self::CART, []);

        unset($cart[$id]);
        session([self::CART => $cart]);

        return response()->json(['ok' => true]);
    }

    /**
     * Validasi pilihan dari keranjang, lalu lanjut ke halaman checkout.
     */
    public function checkout(Request $request)
    {
        $data = $request->validate([
            'items'   => ['required', 'array', 'min:1'],
            'items.*' => ['integer'],
            'qty'     => ['nullable', 'array'],
            'qty.*'   => ['nullable', 'integer', 'min:1', 'max:999'],
        ], [
            'items.required' => 'Pilih minimal satu produk untuk checkout.',
            'items.min'      => 'Pilih minimal satu produk untuk checkout.',
        ]);

        // Samakan jumlah dengan yang terakhir tampil di form
        $cart = session(self::CART, []);

        foreach ($data['qty'] ?? [] as $id => $jumlah) {
            if (isset($cart[$id]) && $jumlah) {
                $cart[$id] = (int) $jumlah;
            }
        }

        session([self::CART => $cart]);

        $selected = $this->lines()
            ->whereIn('id_produk', $data['items'])
            ->values();

        if ($selected->isEmpty()) {
            return redirect()->route('pelanggan.keranjang.index')
                ->with('error', 'Produk yang dipilih tidak ditemukan di keranjang.');
        }

        // ATURAN: semua produk yang di-checkout harus berasal dari satu grup
        $groups = $selected->pluck('nama_group', 'id_group');

        if ($groups->count() > 1) {
            return redirect()->route('pelanggan.keranjang.index')
                ->with('error', 'Produk dari grup berbeda tidak bisa di-checkout bersamaan ('
                    . $groups->implode(', ') . '). Pilih produk dari satu grup saja.');
        }

        session([self::CHECKOUT => $selected->pluck('jumlah', 'id_produk')->all()]);

        return redirect()->route('pelanggan.checkout');
    }

    /**
     * Isi keranjang lengkap dengan data produk, toko, dan grup.
     * Harga selalu diambil dari database, bukan dari session.
     */
    private function lines(): Collection
    {
        $cart = session(self::CART, []);

        if (empty($cart)) {
            return collect();
        }

        $produk = Produk::aktif()
            ->with('toko')
            ->whereIn('id_produk', array_keys($cart))
            ->get()
            ->keyBy('id_produk');

        // Buang produk yang sudah dihapus / nonaktif / habis, rapikan jumlah terhadap stok
        $clean = [];

        foreach ($cart as $id => $jumlah) {
            $p = $produk->get($id);

            if (! $p || (int) $p->stok < 1) {
                continue;
            }

            $clean[$id] = max(1, min((int) $jumlah, (int) $p->stok));
        }

        if ($clean !== $cart) {
            session([self::CART => $clean]);
        }

        $idGroups = $produk
            ->map(fn ($p) => (int) ($p->toko->id_group ?? 0))
            ->unique()
            ->filter()
            ->values();

        $namaGroup = ManagementGroup::whereIn('id_group', $idGroups)->pluck('nama_group', 'id_group');

        return collect($clean)->map(function ($jumlah, $id) use ($produk, $namaGroup) {
            $p       = $produk[$id];
            $idGroup = (int) ($p->toko->id_group ?? 0);
            $harga   = (int) round($p->harga);

            return [
                'id_produk'  => $p->id_produk,
                'nama'       => $p->nama_produk,
                'harga'      => $harga,
                'stok'       => (int) $p->stok,
                'gambar'     => $p->gambar,
                'jumlah'     => $jumlah,
                'subtotal'   => $harga * $jumlah,
                'id_toko'    => (int) $p->id_toko,
                'nama_toko'  => $p->toko->nama_toko ?? 'Toko',   // SESUAIKAN nama kolom toko
                'id_group'   => $idGroup,
                'nama_group' => $namaGroup[$idGroup] ?? 'Tanpa Grup',
            ];
        })->values();
    }
}