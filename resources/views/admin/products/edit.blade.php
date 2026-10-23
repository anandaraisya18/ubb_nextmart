
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Produk - UBB Nexmart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        .main {
            margin-left: 256px;
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
            margin-bottom: 25px;
        }

        .page-header h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #69758b;
            font-size: 14px;
            line-height: 1.6;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 24, 64, 0.06);
            max-width: 1000px;
        }

        .section-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 22px;
            color: #001840;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #263653;
        }

        .form-group label span {
            color: #d32f2f;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            border: 1px solid #d8deea;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 14px;
            color: #001840;
            background: white;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #102A71;
            box-shadow: 0 0 0 3px rgba(16, 42, 113, 0.08);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
            line-height: 1.6;
        }

        .form-group input[type="file"] {
            padding: 10px;
            cursor: pointer;
        }

        .help-text {
            margin-top: 6px;
            font-size: 11px;
            line-height: 1.6;
            color: #8a94a6;
        }

        .error-box {
            background: #fff0f0;
            border: 1px solid #f1b4b4;
            color: #a52828;
            padding: 15px 18px;
            border-radius: 9px;
            margin-bottom: 22px;
            font-size: 13px;
        }

        .error-box ul {
            margin-left: 18px;
            margin-top: 7px;
        }

        .error-box li {
            margin-bottom: 4px;
        }

        .current-image {
            margin-top: 4px;
            margin-bottom: 15px;
        }

        .current-image img,
        .image-preview img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #d8deea;
        }

        .current-image p {
            font-size: 11px;
            color: #8a94a6;
            margin-top: 6px;
        }

        .image-preview {
            margin-top: 12px;
            display: none;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 30px;
            padding-top: 22px;
            border-top: 1px solid #edf0f5;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            text-align: center;
            transition: background-color 0.2s;
        }

        .btn-secondary {
            background: #eef1f6;
            color: #102A71;
        }

        .btn-secondary:hover {
            background: #e2e6ee;
        }

        .btn-primary {
            background: #F5C400;
            color: #001840;
        }

        .btn-primary:hover {
            background: #e0b400;
        }

        @media (max-width: 1024px) {
            .main {
                padding: 28px 24px;
            }
        }

        @media (max-width: 850px) {
            .main {
                margin-left: 0;
                padding: 25px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }
        }

        @media (max-width: 480px) {
            .main {
                padding: 18px 14px;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .card {
                padding: 20px 16px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    @include('admin.components.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="main">

        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>›</span>
            <a href="{{ route('admin.products.index') }}">Produk</a>
            <span>›</span>
            Edit Produk
        </div>

        <div class="page-header">
            <h1>Edit Produk</h1>
            <p>Perbarui informasi produk yang tersedia di katalog UBB Nexmart.</p>
        </div>

        {{-- ERROR VALIDATION --}}
        @if ($errors->any())
            <div class="error-box">
                <strong>Terdapat kesalahan pada data:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM EDIT PRODUK --}}
        <div class="card">

            <div class="section-title">Informasi Produk</div>

            <form
                action="{{ route('admin.products.update', $product) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                <div class="form-grid">

                    {{-- NAMA PRODUK --}}
                    <div class="form-group full">
                        <label for="nama_produk">
                            Nama Produk <span>*</span>
                        </label>

                        <input
                            type="text"
                            id="nama_produk"
                            name="nama_produk"
                            value="{{ old('nama_produk', $product->nama_produk) }}"
                            placeholder="Contoh: Pulpen Joyko"
                            maxlength="150"
                            required
                        >
                    </div>

                    {{-- KATEGORI --}}
                    <div class="form-group">
                        <label for="id_kategori">
                            Kategori <span>*</span>
                        </label>

                        <select id="id_kategori" name="id_kategori" required>
                            <option value="">Pilih kategori</option>

                            @foreach ($kategori as $item)
                                <option
                                    value="{{ $item->id_kategori }}"
                                    {{ (string) old('id_kategori', $product->id_kategori) === (string) $item->id_kategori ? 'selected' : '' }}
                                >
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TOKO --}}
                    <div class="form-group">
                        <label for="id_toko">
                            Toko <span>*</span>
                        </label>

                        <select id="id_toko" name="id_toko" required>
                            <option value="">Pilih toko</option>

                            @foreach ($toko as $item)
                                <option
                                    value="{{ $item->id_toko }}"
                                    {{ (string) old('id_toko', $product->id_toko) === (string) $item->id_toko ? 'selected' : '' }}
                                >
                                    {{ $item->nama_toko }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- HARGA --}}
                    <div class="form-group">
                        <label for="harga">
                            Harga (Rp) <span>*</span>
                        </label>

                        <input
                            type="number"
                            id="harga"
                            name="harga"
                            value="{{ old('harga', $product->harga) }}"
                            placeholder="Contoh: 5000"
                            min="0"
                            required
                        >

                        <div class="help-text">
                            Masukkan harga dalam rupiah.
                        </div>
                    </div>

                    {{-- STOK --}}
                    <div class="form-group">
                        <label for="stok">
                            Stok <span>*</span>
                        </label>

                        <input
                            type="number"
                            id="stok"
                            name="stok"
                            value="{{ old('stok', $product->stok) }}"
                            placeholder="Contoh: 100"
                            min="0"
                            required
                        >
                    </div>

                    {{-- STATUS --}}
                    <div class="form-group">
                        <label for="status">
                            Status Produk <span>*</span>
                        </label>

                        <select id="status" name="status" required>
                            <option
                                value="aktif"
                                {{ old('status', $product->status) === 'aktif' ? 'selected' : '' }}
                            >
                                Aktif
                            </option>

                            <option
                                value="nonaktif"
                                {{ old('status', $product->status) === 'nonaktif' ? 'selected' : '' }}
                            >
                                Nonaktif
                            </option>
                        </select>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="form-group full">
                        <label for="deskripsi">Deskripsi Produk</label>

                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            placeholder="Masukkan deskripsi produk..."
                        >{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    </div>

                    {{-- GAMBAR PRODUK --}}
                    <div class="form-group full">
                        <label for="gambar">Gambar Produk</label>

                        @if ($product->gambar)
                            <div class="current-image">
                                <img
                                    src="{{ asset('storage/' . $product->gambar) }}"
                                    alt="Gambar {{ $product->nama_produk }}"
                                >

                                <p>Gambar produk saat ini</p>
                            </div>
                        @endif

                        <input
                            type="file"
                            id="gambar"
                            name="gambar"
                            accept=".jpg,.jpeg,.png,.webp"
                            onchange="previewImage(event)"
                        >

                        <div class="help-text">
                            Format JPG, JPEG, PNG, atau WEBP dengan ukuran maksimal 2 MB.
                            Jika tidak memilih gambar baru, gambar lama tetap digunakan.
                        </div>

                        <div class="image-preview" id="imagePreview">
                            <img
                                id="preview"
                                src="#"
                                alt="Preview gambar produk baru"
                            >
                        </div>
                    </div>

                </div>

                {{-- ACTION --}}
                <div class="form-actions">
                    <a
                        href="{{ route('admin.products.index') }}"
                        class="btn btn-secondary"
                    >
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Update Produk
                    </button>
                </div>

            </form>
        </div>

    </main>

    {{-- IMAGE PREVIEW --}}
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '#';
                previewContainer.style.display = 'none';
            }
        }
    </script>

</body>
</html>
