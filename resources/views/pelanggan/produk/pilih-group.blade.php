@extends('pelanggan.layouts.app')

@section('title', 'Pilih Grup Toko - UBB Nextmart')

@section('content')

<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-5">

        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-[#001840]">
                Pilih Grup Toko
            </h1>

            <p class="text-gray-500 mt-3">
                Pilih grup toko untuk melihat produk yang tersedia.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @forelse($groups as $group)

                <a href="{{ route('pelanggan.produk.index', ['group' => $group->id_group]) }}"
                   class="bg-white rounded-2xl border border-gray-200
                          overflow-hidden shadow-sm hover:shadow-xl
                          hover:-translate-y-1 transition-all duration-300">

                    <div class="h-56 bg-[#001840] flex items-center justify-center">

                        <div class="text-center px-6">
                            <p class="text-[#F5C400] text-sm font-semibold">
                                UBB NEXTMART
                            </p>

                            <h2 class="text-white text-2xl font-bold mt-3">
                                {{ $group->nama_group }}
                            </h2>
                        </div>

                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[#001840]">
                            {{ $group->nama_group }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-2">
                            Lihat produk dari toko dalam grup ini.
                        </p>

                        <div class="mt-5 text-[#102A71] font-semibold">
                            Lihat Produk →
                        </div>
                    </div>

                </a>

            @empty

                <div class="md:col-span-2 text-center py-16">
                    <p class="text-gray-500">
                        Belum ada grup toko yang tersedia.
                    </p>
                </div>

            @endforelse

        </div>

    </div>
</div>

@endsection
