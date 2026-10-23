<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Data Pembeli</title>

    <link
        rel="stylesheet"
        href="{{ asset('css/payment.css') }}"
    >

</head>

<body>

<div class="payment-container">

    <header class="payment-header">

        <div class="brand">

            <div class="brand-logo">
                U
            </div>

            <div>
                <strong>UBB Mart &</strong>
                <span>Gubuk Printing</span>
            </div>

        </div>

    </header>


    <!-- STEPPER -->

    <div class="stepper">

        <div class="step completed">
            <div class="step-number">✓</div>
            <span>Keranjang</span>
        </div>

        <div class="step-line active-line"></div>

        <div class="step active">
            <div class="step-number">2</div>
            <span>Data Diri</span>
        </div>

        <div class="step-line"></div>

        <div class="step">
            <div class="step-number">3</div>
            <span>Pembayaran</span>
        </div>

        <div class="step-line"></div>

        <div class="step">
            <div class="step-number">4</div>
            <span>Resi</span>
        </div>

    </div>


    <div class="checkout-grid">

        <!-- FORM -->

        <div class="card">

            <div class="card-header">

                <div>

                    <h2>Informasi Pembeli</h2>

                    <p>
                        Lengkapi data sebelum melanjutkan pembayaran.
                    </p>

                </div>

            </div>


            @if($errors->any())

                <div class="alert-error">

                    {{ $errors->first() }}

                </div>

            @endif


            <form
                action="{{ route('payment.processCustomer') }}"
                method="POST"
                id="customerForm"
            >

                @csrf


                <div class="form-group">

                    <label>
                        Nama Lengkap
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Contoh: Raisya Ananda"
                        value="{{ old('name') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        No. HP
                        <span>*</span>
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        placeholder="Contoh: 08123456789"
                        value="{{ old('phone') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Email
                        <span>*</span>
                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Contoh: raisya@email.com"
                        value="{{ old('email') }}"
                        required
                    >

                </div>


                <div class="button-group">

                    <a
                        href="{{ route('payment.cart') }}"
                        class="btn-secondary"
                    >
                        ← Kembali
                    </a>


                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        Lanjut ke Pembayaran
                    </button>

                </div>

            </form>

        </div>


        <!-- SUMMARY -->

        <div class="card summary-card">

            <h2>Ringkasan Pesanan</h2>

            @foreach($items as $item)

                <div class="summary-product">

                    <span>
                        {{ $item['name'] }}
                    </span>

                    <strong>
                        Rp{{ number_format(
                            $item['price'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>

            @endforeach


            <div class="summary-divider"></div>


            <div class="summary-row total-row">

                <span>Total Harga</span>

                <strong>
                    Rp{{ number_format(
                        $total,
                        0,
                        ',',
                        '.'
                    ) }}
                </strong>

            </div>

        </div>

    </div>

</div>

</body>
</html>