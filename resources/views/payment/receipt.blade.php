<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Resi Pembayaran</title>

    <link
        rel="stylesheet"
        href="{{ asset('css/payment.css') }}"
    >

</head>


<body>

<div class="receipt-container">


    <!-- RECEIPT -->

    <div class="receipt-card" id="receipt">


        <div class="receipt-header">

            <div class="brand">

                <div class="brand-logo">
                    U
                </div>

                <div>
                    <strong>UBB Mart &</strong>
                    <span>Gubuk Printing</span>
                </div>

            </div>


            <div class="receipt-thanks">

                <strong>
                    Terima Kasih!
                </strong>

                <span>
                    Simpan resi sebagai bukti transaksi.
                </span>

            </div>

        </div>


        <!-- STATUS -->

        <div class="status-box">

            <span class="status-label">
                Status Pembayaran
            </span>

            <strong>
                🟡 {{ $status }}
            </strong>

            @if($paidAt)

                <small>
                    Bukti pembayaran diterima
                    {{ $paidAt }}
                </small>

            @endif

        </div>


        <!-- RECEIPT NUMBER -->

        <div class="receipt-number">

            <span>
                Nomor Resi
            </span>

            <strong>
                {{ $receipt }}
            </strong>

        </div>


        <div class="receipt-divider"></div>


        <!-- CUSTOMER -->

        <section class="receipt-section">

            <h3>
                Data Pembeli
            </h3>


            <div class="receipt-info">

                <div>

                    <span>Nama</span>

                    <strong>
                        {{ $customer['name'] }}
                    </strong>

                </div>


                <div>

                    <span>No. HP</span>

                    <strong>
                        {{ $customer['phone'] }}
                    </strong>

                </div>


                <div>

                    <span>Email</span>

                    <strong>
                        {{ $customer['email'] }}
                    </strong>

                </div>

            </div>

        </section>


        <div class="receipt-divider"></div>


        <!-- ORDER -->

        <section class="receipt-section">

            <h3>
                Rincian Pesanan
            </h3>


            @foreach($items as $item)

            <div class="receipt-product">

                <div>

                    <strong>
                        {{ $item['name'] }}
                    </strong>

                    <span>
                        {{ $item['qty'] }} ×
                        Rp{{ number_format(
                            $item['price'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </span>

                </div>


                <strong>

                    Rp{{ number_format(
                        $item['price'] * $item['qty'],
                        0,
                        ',',
                        '.'
                    ) }}

                </strong>

            </div>

            @endforeach

        </section>


        <div class="receipt-divider"></div>


        <!-- TOTAL -->

        <div class="receipt-total">

            <span>
                Total Pembayaran
            </span>

            <strong>
                Rp{{ number_format(
                    $total,
                    0,
                    ',',
                    '.'
                ) }}
            </strong>

        </div>


        <!-- TIMELINE -->

        <section class="receipt-section">

            <h3>
                Status Pesanan
            </h3>


            <div class="timeline">

                <div class="timeline-item active">

                    <div class="timeline-dot">
                        ✓
                    </div>

                    <div>
                        <strong>
                            Pesanan Dibuat
                        </strong>

                        <span>
                            Pesanan berhasil dibuat.
                        </span>
                    </div>

                </div>


                <div class="timeline-item active">

                    <div class="timeline-dot">
                        ✓
                    </div>

                    <div>

                        <strong>
                            Bukti Pembayaran Diupload
                        </strong>

                        <span>
                            Bukti pembayaran telah diterima.
                        </span>

                    </div>

                </div>


                <div class="timeline-item current">

                    <div class="timeline-dot">
                        3
                    </div>

                    <div>

                        <strong>
                            Menunggu Verifikasi
                        </strong>

                        <span>
                            Admin sedang memeriksa
                            pembayaran Anda.
                        </span>

                    </div>

                </div>


                <div class="timeline-item">

                    <div class="timeline-dot">
                        4
                    </div>

                    <div>

                        <strong>
                            Pesanan Diproses
                        </strong>

                        <span>
                            Menunggu verifikasi pembayaran.
                        </span>

                    </div>

                </div>

            </div>

        </section>


        <!-- IMPORTANT -->

        <div class="important-box">

            <strong>
                ⚠ Penting
            </strong>

            <p>
                Wajib simpan resi ini sebagai bukti
                transaksi. Anda dapat menggunakan
                nomor resi untuk mengecek status
                pesanan.
            </p>

        </div>


        <button
            onclick="downloadReceipt()"
            class="btn-primary download-button"
        >
            ↓ Download Resi
        </button>


    </div>

</div>


<script>

function downloadReceipt()
{
    window.print();
}

</script>

</body>

</html>