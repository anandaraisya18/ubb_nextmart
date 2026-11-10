<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Keranjang - UBB Mart & Gubuk Printing</title>

    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
</head>

<body>

<div class="payment-container">

    <!-- HEADER -->
    <header class="payment-header">
        <div class="brand">
            <div class="brand-logo">U</div>

            <div>
                <strong>UBB Mart &</strong>
                <span>Gubuk Printing</span>
            </div>
        </div>
    </header>


    <!-- STEPPER -->
    <div class="stepper">

        <div class="step active">
            <div class="step-number">1</div>
            <span>Keranjang</span>
        </div>

        <div class="step-line"></div>

        <div class="step">
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


    @if(session('error'))

        <div class="alert-error">
            {{ session('error') }}
        </div>

    @endif


    <!-- CONTENT -->

    <form action="{{ route('payment.processCart') }}" method="POST">

        @csrf

        <div class="checkout-grid">

            <!-- ITEMS -->

            <div class="card">

                <div class="card-header">

                    <div>
                        <h2>Keranjang Belanja</h2>
                        <p>Pilih item yang ingin Anda pesan.</p>
                    </div>

                    <label class="select-all">
                        <input type="checkbox" id="selectAll">
                        Pilih Semua
                    </label>

                </div>


                <div class="product-list">

                    @foreach($items as $item)

                    <label class="product-item">

                        <input
                            type="checkbox"
                            name="items[]"
                            value="{{ $item['id'] }}"
                            class="item-checkbox"
                        >

                        <div class="product-image">
                            <span>IMG</span>
                        </div>

                        <div class="product-info">

                            <h3>{{ $item['name'] }}</h3>

                            <p>
                                Rp{{ number_format($item['price'], 0, ',', '.') }}
                            </p>

                        </div>

                        <div class="product-price">

                            Rp{{ number_format(
                                $item['price'] * $item['qty'],
                                0,
                                ',',
                                '.'
                            ) }}

                        </div>

                    </label>

                    @endforeach

                </div>

            </div>


            <!-- SUMMARY -->

            <div class="card summary-card">

                <h2>Ringkasan Pesanan</h2>

                <div class="summary-row">

                    <span>Item dipilih</span>

                    <strong id="selectedCount">0 item</strong>

                </div>

                <div class="summary-divider"></div>

                <div class="summary-row total-row">

                    <span>Total Harga</span>

                    <strong id="totalPrice">Rp0</strong>

                </div>

                <button
                    type="submit"
                    id="continueButton"
                    class="btn-primary"
                    disabled
                >
                    Lanjut ke Data Diri
                </button>

            </div>

        </div>

    </form>

</div>


<script>

const checkboxes = document.querySelectorAll('.item-checkbox');

const selectAll = document.getElementById('selectAll');

const continueButton = document.getElementById('continueButton');

const selectedCount = document.getElementById('selectedCount');

const totalPrice = document.getElementById('totalPrice');


const prices = @json(
    collect($items)->pluck('price', 'id')
);


function updateCart()
{
    let count = 0;
    let total = 0;

    checkboxes.forEach(function(checkbox)
    {
        if (checkbox.checked)
        {
            count++;

            total += Number(prices[checkbox.value]);
        }
    });


    selectedCount.textContent = count + ' item';


    totalPrice.textContent =
        'Rp' + total.toLocaleString('id-ID');


    continueButton.disabled = count === 0;


    selectAll.checked =
        count === checkboxes.length && checkboxes.length > 0;
}


checkboxes.forEach(function(checkbox)
{
    checkbox.addEventListener('change', updateCart);
});


selectAll.addEventListener('change', function()
{
    checkboxes.forEach(function(checkbox)
    {
        checkbox.checked = selectAll.checked;
    });

    updateCart();
});

</script>

</body>
</html>