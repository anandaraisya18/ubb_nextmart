<footer class="bg-[#001840] text-white mt-16">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-10 h-10 rounded-xl bg-[#102A71]
                                flex items-center justify-center">

                        <img
                            src="{{ asset('images/logoubb.png') }}"
                            alt="UBB"
                            class="w-7 h-7 object-contain"
                        >

                    </div>

                    <div>
                        <h3 class="font-bold">
                            UBB Nextmart
                        </h3>

                        <p class="text-xs text-[#F5C400]">
                            Marketplace UBB
                        </p>
                    </div>

                </div>

                <p class="text-sm text-white/60 leading-relaxed">
                    Platform untuk melihat produk,
                    melakukan pemesanan, pembayaran,
                    dan memantau pesanan di UBB Nextmart.
                </p>

            </div>


            <div>

                <h3 class="font-semibold mb-4">
                    Navigasi
                </h3>

                <div class="space-y-2 text-sm text-white/60">

                    <a href="{{ route('pelanggan.dashboard') }}"
                       class="block hover:text-[#F5C400]">
                        Beranda
                    </a>

                    <a href="{{ route('pelanggan.produk.index') }}"
                       class="block hover:text-[#F5C400]">
                        Produk
                    </a>

                    <a href="{{ route('pelanggan.pesanan.index') }}"
                       class="block hover:text-[#F5C400]">
                        Pesanan
                    </a>

                </div>

            </div>


            <div>

                <h3 class="font-semibold mb-4">
                    UBB Nextmart
                </h3>

                <p class="text-sm text-white/60 leading-relaxed">
                    Belanja produk dari UBB Mart,
                    Gubuk Printing, dan New Combi
                    melalui satu platform.
                </p>

            </div>

        </div>


        <div class="border-t border-white/10 mt-8 pt-6 text-center">

            <p class="text-xs text-white/40">
                &copy; {{ date('Y') }} UBB Nextmart.
                All rights reserved.
            </p>

        </div>

    </div>

</footer>