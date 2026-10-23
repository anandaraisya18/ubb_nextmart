<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Resi Pesanan - UBB Nexmart</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f4f6fa;
            color: #001840;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #001840;
            color: white;
            padding: 28px 20px;
            z-index: 10;
        }

        .logo {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .logo span {
            color: #F5C400;
        }

        .subtitle {
            font-size: 12px;
            color: #b9c3d8;
            margin-bottom: 35px;
        }

        .menu-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #8492ad;
            margin-bottom: 12px;
            letter-spacing: 1px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu a {
            text-decoration: none;
            color: #dbe2ef;
            padding: 13px 15px;
            border-radius: 9px;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu a:hover {
            background: #102A71;
            color: white;
        }

        .menu a.active {
            background: #102A71;
            color: white;
            font-weight: 600;
        }

        .logout {
            position: absolute;
            bottom: 25px;
            left: 20px;
            right: 20px;
        }

        .logout a {
            display: block;
            text-align: center;
            text-decoration: none;
            padding: 11px;
            border: 1px solid #33466f;
            border-radius: 8px;
            color: #dbe2ef;
            font-size: 13px;
        }

        .logout a:hover {
            background: #102A71;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main {
            margin-left: 250px;
            min-height: 100vh;
            padding: 35px 45px;
        }

        .breadcrumb {
            font-size: 13px;
            color: #7c879b;
            margin-bottom: 25px;
        }

        .breadcrumb a {
            color: #102A71;
            text-decoration: none;
        }

        .breadcrumb span {
            margin: 0 7px;
        }

        .page-header {
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #69758b;
            font-size: 14px;
        }

        /* =========================
           SUCCESS BOX
        ========================= */

        .success-card {
            background: white;
            border-radius: 14px;
            padding: 28px;
            text-align: center;
            margin-bottom: 22px;
            box-shadow: 0 5px 20px rgba(0, 24, 64, 0.06);
        }

        .success-icon {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: #e8f7ed;
            color: #20934c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 15px;
            font-weight: bold;
        }

        .success-card h2 {
            font-size: 22px;
            margin-bottom: 8px;
        }

        .success-card p {
            color: #6d788c;
            font-size: 14px;
            line-height: 1.6;
        }

        /* =========================
           RECEIPT LAYOUT
        ========================= */

        .content-grid {
            display: grid;
            grid-template-columns: 1.4fr 0.8fr;
            gap: 22px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 24, 64, 0.06);
        }

        .card-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* =========================
           RECEIPT NUMBER
        ========================= */

        .receipt-number {
            background: #f5f7fb;
            border: 1px dashed #b9c4d7;
            border-radius: 10px;
            padding: 17px;
            text-align: center;
            margin-bottom: 22px;
        }

        .receipt-number small {
            display: block;
            color: #7a8598;
            font-size: 11px;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .receipt-number strong {
            color: #102A71;
            font-size: 23px;
            letter-spacing: 1px;
        }

        /* =========================
           STATUS
        ========================= */

        .status-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff9dc;
            border: 1px solid #f0df82;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 22px;
        }

        .status-label {
            font-size: 13px;
            color: #6d6540;
        }

        .status {
            font-size: 12px;
            font-weight: 700;
            color: #8a7000;
            background: #fff1a8;
            padding: 7px 12px;
            border-radius: 20px;
        }

        /* =========================
           ORDER ITEMS
        ========================= */

        .item {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #edf0f5;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .item-qty {
            font-size: 12px;
            color: #7a8598;
        }

        .item-price {
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 2px solid #102A71;
            margin-top: 10px;
            padding-top: 17px;
        }

        .total span:first-child {
            font-size: 15px;
            font-weight: 700;
        }

        .total span:last-child {
            color: #102A71;
            font-size: 20px;
            font-weight: 700;
        }

        /* =========================
           CUSTOMER
        ========================= */

        .info-row {
            padding: 12px 0;
            border-bottom: 1px solid #edf0f5;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            display: block;
            font-size: 11px;
            color: #8a94a6;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
        }

        /* =========================
           PAYMENT INFO
        ========================= */

        .payment-info {
            background: #f5f7fb;
            border-radius: 10px;
            padding: 16px;
            margin-top: 20px;
        }

        .payment-info h4 {
            font-size: 13px;
            margin-bottom: 10px;
        }

        .payment-info p {
            font-size: 12px;
            color: #68748a;
            line-height: 1.6;
        }

        /* =========================
           BUTTONS
        ========================= */

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 22px;
        }

        .btn {
            flex: 1;
            padding: 12px 15px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: #102A71;
            color: white;
        }

        .btn-primary:hover {
            background: #001840;
        }

        .btn-secondary {
            background: #eef1f6;
            color: #102A71;
        }

        .btn-secondary:hover {
            background: #e2e6ee;
        }

        /* =========================
           PROOF
        ========================= */

        .proof-box {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fc;
            border-radius: 10px;
        }

        .proof-box h4 {
            font-size: 13px;
            margin-bottom: 10px;
        }

        .proof-box a {
            color: #102A71;
            font-size: 13px;
            text-decoration: none;
            font-weight: 600;
        }

        .proof-box a:hover {
            text-decoration: underline;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {
            .sidebar {
                width: 210px;
            }

            .main {
                margin-left: 210px;
                padding: 25px;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .logout {
                position: static;
                margin-top: 25px;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .actions {
                flex-direction: column;
            }
        }

        @media print {
            .sidebar,
            .breadcrumb,
            .actions {
                display: none;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            body {
                background: white;
            }

            .card,
            .success-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>

<body>

    <!-- =========================
         SIDEBAR
    ========================= -->

    <aside class="sidebar">

        <div class="logo">
            UBB <span>Nexmart</span>
        </div>

        <div class="subtitle">
            Sistem Manajemen Toko
        </div>

        <div class="menu-title">
            Menu
        </div>

        <nav class="menu">

            <a href="{{ route('admin.dashboard') }}">
                Dashboard
            </a>

            <a href="{{ route('admin.orders.index') }}">
                Pesanan
            </a>

            <a href="{{ route('payment.cart') }}" class="active">
                Pembayaran
            </a>

        </nav>

        <div class="logout">
            <a href="{{ route('admin.login') }}">
                Keluar
            </a>
        </div>

    </aside>


    <!-- =========================
         MAIN
    ========================= -->

    <main class="main">

        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>›</span>

            <a href="{{ route('payment.cart') }}">Pembayaran</a>
            <span>›</span>

            Resi Pesanan
        </div>


        <div class="page-header">
            <h1>Resi Pesanan</h1>
            <p>
                Detail pesanan dan informasi pembayaran Anda.
            </p>
        </div>


        <!-- =========================
             SUCCESS
        ========================= -->

        <div class="success-card">

            <div class="success-icon">
                ✓
            </div>

            <h2>
                Pesanan Berhasil Dikirim!
            </h2>

            <p>
                Bukti pembayaran Anda telah berhasil diterima.
                Pesanan akan diproses setelah pembayaran diverifikasi oleh admin.
            </p>

        </div>


        <!-- =========================
             CONTENT
        ========================= -->

        <div class="content-grid">

            <!-- LEFT -->
            <div>

                <div class="card">

                    <div class="card-title">
                        Detail Pesanan
                    </div>


                    <!-- NOMOR RESI -->

                    <div class="receipt-number">

                        <small>
                            Nomor Resi
                        </small>

                        <strong>
                            {{ $receipt }}
                        </strong>

                    </div>


                    <!-- STATUS -->

                    <div class="status-box">

                        <span class="status-label">
                            Status Pesanan
                        </span>

                        <span class="status">
                            {{ $status }}
                        </span>

                    </div>


                    <!-- ITEMS -->

                    @foreach ($items as $item)

                        <div class="item">

                            <div class="item-info">

                                <div class="item-name">
                                    {{ $item['name'] }}
                                </div>

                                <div class="item-qty">
                                    {{ $item['qty'] }} ×
                                    Rp{{ number_format($item['price'], 0, ',', '.') }}
                                </div>

                            </div>

                            <div class="item-price">
                                Rp{{ number_format(
                                    $item['price'] * $item['qty'],
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </div>

                        </div>

                    @endforeach


                    <!-- TOTAL -->

                    <div class="total">

                        <span>
                            Total Pembayaran
                        </span>

                        <span>
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </span>

                    </div>

                </div>


                <!-- PAYMENT PROOF -->

                @if ($proof)

                    <div class="card" style="margin-top: 22px;">

                        <div class="card-title">
                            Bukti Pembayaran
                        </div>

                        <div class="proof-box">

                            <h4>
                                File berhasil diupload
                            </h4>

                            <a
                                href="{{ asset('storage/' . $proof) }}"
                                target="_blank"
                            >
                                Lihat Bukti Pembayaran →
                            </a>

                        </div>

                    </div>

                @endif

            </div>


            <!-- RIGHT -->
            <div>

                <div class="card">

                    <div class="card-title">
                        Data Pembeli
                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Nama Lengkap
                        </span>

                        <div class="info-value">
                            {{ $customer['name'] }}
                        </div>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Nomor HP
                        </span>

                        <div class="info-value">
                            {{ $customer['phone'] }}
                        </div>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Email
                        </span>

                        <div class="info-value">
                            {{ $customer['email'] }}
                        </div>

                    </div>


                    @if ($paidAt)

                        <div class="info-row">

                            <span class="info-label">
                                Waktu Pembayaran
                            </span>

                            <div class="info-value">
                                {{ $paidAt }}
                            </div>

                        </div>

                    @endif


                    <div class="payment-info">

                        <h4>
                            Informasi
                        </h4>

                        <p>
                            Simpan nomor resi ini untuk melakukan
                            pelacakan pesanan. Status pesanan akan
                            diperbarui setelah admin melakukan verifikasi
                            pembayaran.
                        </p>

                    </div>

                </div>


                <!-- ACTION -->

                <div class="actions">

                    <a
                        href="{{ route('payment.cart') }}"
                        class="btn btn-secondary"
                    >
                        Kembali
                    </a>

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="window.print()"
                    >
                        Cetak Resi
                    </button>

                </div>

            </div>

        </div>

    </main>

</body>
</html>