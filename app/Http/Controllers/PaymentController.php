<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Halaman keranjang
     */
    public function cart()
    {
        $items = DB::table('produk')
            ->where('status', 'aktif')
            ->where('stok', '>', 0)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id_produk,
                    'name' => $product->nama_produk,
                    'price' => $product->harga,
                    'qty' => 1,
                ];
            })
            ->toArray();

        return view('admin.payment.cart', compact('items'));
    }

    /**
     * Memproses item yang dipilih
     */
    public function processCart(Request $request)
    {
        $selectedItems = $request->input('items', []);

        if (!is_array($selectedItems) || empty($selectedItems)) {
            return back()->with(
                'error',
                'Silakan pilih minimal satu item.'
            );
        }

        $selectedItems = array_unique($selectedItems);

        $products = DB::table('produk')
            ->whereIn('id_produk', $selectedItems)
            ->where('status', 'aktif')
            ->where('stok', '>', 0)
            ->get();

        if ($products->count() !== count($selectedItems)) {
            return back()->with(
                'error',
                'Ada produk yang tidak tersedia.'
            );
        }

        $items = [];

        foreach ($products as $product) {
            $items[] = [
                'id' => $product->id_produk,
                'name' => $product->nama_produk,
                'price' => $product->harga,
                'qty' => 1,
            ];
        }

        $total = collect($items)->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });

        session([
            'payment.items' => $items,
            'payment.total' => $total,
        ]);

        return redirect()->route('payment.customer');
    }

    /**
     * Halaman data pembeli
     */
    public function customer()
    {
        if (!session()->has('payment.items')) {
            return redirect()->route('payment.cart');
        }

        $items = session('payment.items');
        $total = session('payment.total');

        return view('admin.payment.customer', compact(
            'items',
            'total'
        ));
    }

    /**
     * Menyimpan data pembeli
     */
    public function processCustomer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        session([
            'payment.customer' => $validated,
        ]);

        return redirect()->route('payment.payment');
    }

    /**
     * Halaman pembayaran
     */
    public function payment()
    {
        if (
            !session()->has('payment.items') ||
            !session()->has('payment.customer')
        ) {
            return redirect()->route('payment.cart');
        }

        $items = session('payment.items');
        $total = session('payment.total');
        $customer = session('payment.customer');

        return view('admin.payment.payment', compact(
            'items',
            'total',
            'customer'
        ));
    }

    /**
     * Upload bukti pembayaran
     */
    public function uploadProof(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diupload.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
            'payment_proof.max' => 'Ukuran file maksimal 2 MB.',
        ]);

        $file = $request->file('payment_proof');

        $filename = time() . '_' . Str::random(8) . '.' . $file->extension();

        $path = $file->storeAs(
            'payment_proofs',
            $filename,
            'public'
        );

        /*
        |--------------------------------------------------------------------------
        | Generate nomor resi dummy
        |--------------------------------------------------------------------------
        */

        $receiptNumber = 'UBB' . strtoupper(Str::random(8));

        session([
            'payment.proof' => $path,
            'payment.receipt' => $receiptNumber,
            'payment.status' => 'Menunggu Verifikasi',
            'payment.paid_at' => now()->format('d M Y, H:i'),
        ]);

        return redirect()->route(
            'payment.receipt',
            $receiptNumber
        );
    }

    /**
     * Halaman resi
     */
    public function receipt($receipt)
    {
        if (
            !session()->has('payment.items') ||
            !session()->has('payment.customer') ||
            !session()->has('payment.receipt')
        ) {
            return redirect()->route('payment.cart');
        }

        $items = session('payment.items');
        $total = session('payment.total');
        $customer = session('payment.customer');

        $status = session(
            'payment.status',
            'Menunggu Pembayaran'
        );

        $proof = session('payment.proof');
        $paidAt = session('payment.paid_at');

        return view('admin.payment.receipt', compact(
            'items',
            'total',
            'customer',
            'status',
            'proof',
            'paidAt',
            'receipt'
        ));
    }
}
