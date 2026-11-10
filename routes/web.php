
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Superadmin\AuditLogController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Superadmin\AuthController as SuperadminAuthController;
use App\Http\Controllers\Superadmin\AdminController;
use App\Http\Controllers\Superadmin\TokoController;
use App\Http\Controllers\Superadmin\ManagementGroupController;
use App\Http\Controllers\Admin\PrintController;

use App\Http\Controllers\Pelanggan\ProdukController;
use App\Http\Controllers\Pelanggan\KeranjangController;
use App\Http\Controllers\Pelanggan\CheckoutController;
use App\Http\Controllers\Pelanggan\PembayaranController;
use App\Http\Controllers\Pelanggan\PesananController;
use App\Http\Controllers\Pelanggan\PelangganAuthController;
use App\Http\Controllers\Pelanggan\CetakController;


/*
|--------------------------------------------------------------------------
| WEBSITE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| LOGIN ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('guest:admin')->group(function () {

    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
        ->name('admin.login');

    Route::post('/admin/login', [AdminAuthController::class, 'login'])
        ->name('admin.login.process');

    Route::get('/admin/forgot-password', [AdminAuthController::class, 'showForgotPassword'])
        ->name('admin.password.request');

    Route::post('/admin/forgot-password', [AdminAuthController::class, 'sendResetLink'])
        ->middleware('throttle:3,1')
        ->name('admin.password.email');

    Route::get('/admin/reset-password/{token}', [AdminAuthController::class, 'showResetPassword'])
        ->name('admin.password.reset');

    Route::post('/admin/reset-password', [AdminAuthController::class, 'resetPassword'])
        ->name('admin.password.update');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD DAN FITUR ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('admin.session')->group(function () {

    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
        ->name('admin.logout');

    Route::get('/admin/dashboard', [OrderController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Produk
    Route::resource('/admin/products', ProductController::class)
        ->names('admin.products');

    // Kategori
    Route::resource('/admin/categories', CategoryController::class)
        ->names('admin.categories')
        ->parameters(['categories' => 'category'])
        ->except(['show']);

    // Pesanan
    Route::resource('/admin/orders', OrderController::class)
        ->names('admin.orders')
        ->parameters(['orders' => 'order']);

    Route::patch('/admin/orders/{order}/pengantaran', [OrderController::class, 'pengantaran'])
        ->name('admin.orders.pengantaran');

    // Transaksi
    Route::get('/admin/payment', [AdminPaymentController::class, 'index'])
        ->name('admin.payment.payment');

    Route::get('/admin/payment/export', [AdminPaymentController::class, 'export'])
        ->name('admin.payment.export');

    // Antrian Cetak
    Route::prefix('admin/prints')
        ->name('admin.prints.')
        ->group(function () {

            Route::get('/', [PrintController::class, 'index'])
                ->name('index');

            Route::get('/{id}', [PrintController::class, 'show'])
                ->name('show');

            Route::get('/{id}/download', [PrintController::class, 'download'])
                ->name('download');

            Route::put('/{id}/verifikasi', [PrintController::class, 'updateVerifikasi'])
                ->name('verifikasi');
        });
});


/*
|--------------------------------------------------------------------------
| PEMBAYARAN LAMA
|--------------------------------------------------------------------------
| Dipertahankan agar alur pembayaran lama tidak terganggu.
*/

Route::get('/pembayaran/data-pembeli', [PaymentController::class, 'customer'])
    ->name('payment.customer');

Route::post('/pembayaran/data-pembeli', [PaymentController::class, 'processCustomer'])
    ->name('payment.processCustomer');

Route::get('/pembayaran/bayar', [PaymentController::class, 'payment'])
    ->name('payment.payment');

Route::post('/pembayaran/bukti', [PaymentController::class, 'uploadProof'])
    ->name('payment.uploadProof');

Route::get('/pembayaran/resi/{receipt}', [PaymentController::class, 'receipt'])
    ->name('payment.receipt');


/*
|--------------------------------------------------------------------------
| LOGIN SUPERADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('guest:superadmin')->group(function () {

    Route::get('/superadmin/login', [SuperadminAuthController::class, 'showLogin'])
        ->name('superadmin.login');

    Route::post('/superadmin/login', [SuperadminAuthController::class, 'login'])
        ->name('superadmin.login.process');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD DAN FITUR SUPERADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('superadmin.session')->group(function () {

    // Logout
    Route::post('/superadmin/logout', [SuperadminAuthController::class, 'logout'])
        ->name('superadmin.logout');

    // Dashboard
    Route::get('/superadmin/dashboard', function () {

        $totalAdmin = DB::table('admin')->count();
        $totalGroups = DB::table('management_group')->count();
        $totalStores = DB::table('toko')->count();

        $totalActivities = DB::table('audit_log')
            ->whereDate('created_at', today())
            ->count();

        $groups = DB::table('management_group')
            ->orderBy('id_group')
            ->get();

        foreach ($groups as $group) {
            $group->tokos = DB::table('toko')
                ->where('id_group', $group->id_group)
                ->orderBy('id_toko')
                ->get();
        }

        $activities = DB::table('audit_log')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        return view('superadmin.beranda.dashboard', compact(
            'totalAdmin',
            'totalGroups',
            'totalStores',
            'totalActivities',
            'groups',
            'activities'
        ));

    })->name('superadmin.dashboard');


    // Kelola akun admin
    Route::get('/superadmin/admin', [AdminController::class, 'index'])
        ->name('superadmin.admin.index');

    Route::get('/superadmin/admin/create', [AdminController::class, 'create'])
        ->name('superadmin.admin.create');

    Route::post('/superadmin/admin', [AdminController::class, 'store'])
        ->name('superadmin.admin.store');

    Route::get('/superadmin/admin/{id}/edit', [AdminController::class, 'edit'])
        ->name('superadmin.admin.edit');

    Route::put('/superadmin/admin/{id}', [AdminController::class, 'update'])
        ->name('superadmin.admin.update');

    Route::delete('/superadmin/admin/{id}', [AdminController::class, 'destroy'])
        ->name('superadmin.admin.destroy');


    // Kelola toko
    Route::prefix('superadmin/toko')
        ->name('superadmin.toko.')
        ->group(function () {

            Route::get('/', [TokoController::class, 'index'])
                ->name('index');

            Route::get('/create', [TokoController::class, 'create'])
                ->name('create');

            Route::post('/', [TokoController::class, 'store'])
                ->name('store');

            Route::get('/{id}/edit', [TokoController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [TokoController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [TokoController::class, 'destroy'])
                ->name('destroy');
        });


    // Audit log
    Route::get('/superadmin/audit', [AuditLogController::class, 'index'])
        ->name('superadmin.audit.index');


    // Kelola grup operasional
    Route::prefix('superadmin/groups')
        ->name('superadmin.group.')
        ->group(function () {

            Route::get('/', [ManagementGroupController::class, 'index'])
                ->name('index');

            Route::get('/create', [ManagementGroupController::class, 'create'])
                ->name('create');

            Route::post('/', [ManagementGroupController::class, 'store'])
                ->name('store');

            Route::get('/{id}/edit', [ManagementGroupController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [ManagementGroupController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [ManagementGroupController::class, 'destroy'])
                ->name('destroy');
        });
});


/*
|--------------------------------------------------------------------------
| AUTENTIKASI PELANGGAN
|--------------------------------------------------------------------------
*/

Route::prefix('pelanggan')
    ->name('pelanggan.')
    ->group(function () {

        Route::middleware('guest:pelanggan')->group(function () {

            // Login
            Route::get('/login', [PelangganAuthController::class, 'showLogin'])
                ->name('login');

            Route::post('/login', [PelangganAuthController::class, 'login'])
                ->name('login.process');

            // Registrasi
            Route::get('/register', [PelangganAuthController::class, 'showRegister'])
                ->name('register');

            Route::post('/register', [PelangganAuthController::class, 'register'])
                ->name('register.process');

            // Kirim ulang email aktivasi
            Route::post('/email/resend', [PelangganAuthController::class, 'resend'])
                ->middleware('throttle:3,1')
                ->name('verification.resend');

            // Lupa password
            Route::get('/forgot-password', [PelangganAuthController::class, 'showForgotPassword'])
                ->name('password.request');

            Route::post('/forgot-password', [PelangganAuthController::class, 'sendResetLink'])
                ->middleware('throttle:3,1')
                ->name('password.email');

            // Reset password
            Route::post('/reset-password', [PelangganAuthController::class, 'resetPassword'])
                ->name('password.update');
        });

        // Logout
        Route::post('/logout', [PelangganAuthController::class, 'logout'])
            ->middleware('auth:pelanggan')
            ->name('logout');
    });


// Halaman membuat password baru
Route::get('/pelanggan/reset-password/{token}', [PelangganAuthController::class, 'showResetPassword'])
    ->middleware('guest:pelanggan')
    ->name('password.reset');


// Link aktivasi dari email
Route::get('/pelanggan/email/verify/{id}/{hash}', [PelangganAuthController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');


/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK PELANGGAN
|--------------------------------------------------------------------------
| Bisa diakses tanpa login.
*/

Route::prefix('pelanggan')
    ->name('pelanggan.')
    ->group(function () {

        // Dashboard
        Route::get('/', [ProdukController::class, 'dashboard'])
            ->name('dashboard');

        // Pemilihan grup toko
        Route::get('/pilih-group', [ProdukController::class, 'pilihGroup'])
            ->name('produk.pilihGroup');

        // Produk
        Route::get('/produk', [ProdukController::class, 'index'])
            ->name('produk.index');

        Route::get('/produk/{produk}', [ProdukController::class, 'show'])
            ->name('produk.show');

        // Keranjang
        Route::get('/keranjang', [KeranjangController::class, 'index'])
            ->name('keranjang.index');

        Route::post('/keranjang', [KeranjangController::class, 'store'])
            ->name('keranjang.store');

        Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])
            ->whereNumber('id')
            ->name('keranjang.update');

        Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])
            ->whereNumber('id')
            ->name('keranjang.destroy');

        // Hapus pekerjaan cetak dari keranjang
        Route::delete('/keranjang/cetak/{jobId}', [KeranjangController::class, 'destroyCetak'])
            ->name('keranjang.cetak.destroy');


        // Cetak dokumen
        Route::get('/cetak', [CetakController::class, 'create'])
            ->name('cetak.create');

        Route::post('/cetak', [CetakController::class, 'store'])
            ->name('cetak.store');

        Route::post('/cetak/hitung-halaman', [CetakController::class, 'hitungHalaman'])
            ->name('cetak.hitung');


        // Informasi
        Route::get('/kontak', function () {
            return view('pelanggan.kontak');
        })->name('kontak');

        Route::get('/tentang', function () {
            return view('pelanggan.tentang');
        })->name('tentang');
    });


/*
|--------------------------------------------------------------------------
| CHECKOUT DAN PESANAN PELANGGAN
|--------------------------------------------------------------------------
| Wajib login sebagai pelanggan dan sudah verifikasi email.
*/

Route::prefix('pelanggan')
    ->name('pelanggan.')
    ->middleware(['auth:pelanggan', 'verified'])
    ->group(function () {

        // Proses pilihan keranjang menuju checkout
        Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])
            ->name('keranjang.checkout');

        // Halaman checkout gabungan
        Route::get('/checkout', [CheckoutController::class, 'index'])
            ->name('checkout');

        // Simpan pesanan
        Route::post('/checkout', [CheckoutController::class, 'store'])
            ->name('checkout.store');


        // Pembayaran
        Route::get('/pembayaran', [PembayaranController::class, 'index'])
            ->name('pembayaran');

        Route::post('/pembayaran/bukti', [PembayaranController::class, 'uploadBukti'])
            ->name('pembayaran.bukti');


        // Pesanan
        Route::get('/pesanan', [PesananController::class, 'lacak'])
            ->name('pesanan.index');

        Route::get('/pesanan/lacak', [PesananController::class, 'lacak'])
            ->name('pesanan.lacak');

        Route::get('/pesanan/riwayat', [PesananController::class, 'riwayat'])
            ->name('pesanan.riwayat');

        Route::get('/pesanan/{id}', [PesananController::class, 'show'])
            ->name('pesanan.show');


        // Resi
        Route::get('/resi', function () {
            return view('pelanggan.pesanan.resi');
        })->name('pesanan.resi');
    });
