<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Produk - UBB Nexmart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
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
            font-weight: 700;
            margin: 0 0 8px;
        }

        .page-header p {
            color: #69758b;
            font-size: 14px;
            margin: 0;
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
            transition: 0.2s;
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
        }

        .form-group input[type="file"] {
            padding: 10px;
            cursor: pointer;
        }

        .help-text {
            margin-top: 6px;
            font-size: 11px;
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

        .success-box {
            background: #eefbf2;
            border: 1px solid #b7dfc0;
            color: #1d6b32;
            padding: 15px 18px;
            border-radius: 9px;
            margin-bottom: 22px;
            font-size: 13px;
        }

        .image-preview {
            margin-top: 12px;
            display: none;
        }

        .image-preview img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #d8deea;
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
        }

        .btn-secondary {
            background: #eef1f6;
            color: #102A71;
        }

        .btn-secondary:hover {
            background: #e2e6ee;
        }

        .btn-primary {
            background: #102A71;
            color: white;
        }

        .btn-primary:hover {
            background: #001840;
        }

        .field-error {
            color: #b91c1c;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 1024px) {
            .main {
                margin-left: 256px;
                padding: 25px;
            }
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0;
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .card {
                padding: 20px;
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

    <main class="main">

        {{-- BREADCRUMB --}}
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>›</span>
            <a href="{{ route('admin.products.index') }}">Produk</a>
            <span>›</span>
            Tambah Produk
        </div>

        {{-- HEADER --}}
        <div class="page-header">
            <h1>Tambah Produk</h1>
            <p>Tambahkan produk baru ke dalam katalog UBB Nexmart.</p>
        </div>

        {{-- VALIDATION ERRORS --}}
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

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="success-box">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORM PRODUK --}}
        <div class="card">

            <div class="section-title">Informasi Produk</div>

            <form
                action="{{ route('admin.products.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

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
                            value="{{ old('nama_produk') }}"
                            maxlength="150"
                            placeholder="Contoh: Pulpen Joyko"
                            required
                        >

                        @error('nama_produk')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
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
                                    @selected(old('id_kategori') == $item->id_kategori)
                                >
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_kategori')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
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
                                    @selected(old('id_toko') == $item->id_toko)
                                >
                                    {{ $item->nama_toko }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_toko')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
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
                            value="{{ old('harga') }}"
                            placeholder="Contoh: 5000"
                            min="0"
                            step="1"
                            required
                        >

                        <div class="help-text">
                            Masukkan harga dalam rupiah.
                        </div>

                        @error('harga')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
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
                            value="{{ old('stok', 0) }}"
                            placeholder="Contoh: 100"
                            min="0"
                            step="1"
                            required
                        >

                        @error('stok')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- STATUS --}}
                    <div class="form-group">
                        <label for="status">
                            Status Produk <span>*</span>
                        </label>

                        <select id="status" name="status" required>
                            <option
                                value="aktif"
                                @selected(old('status', 'aktif') === 'aktif')
                            >
                                Aktif
                            </option>

                            <option
                                value="nonaktif"
                                @selected(old('status') === 'nonaktif')
                            >
                                Nonaktif
                            </option>
                        </select>

                        @error('status')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="form-group full">
                        <label for="deskripsi">Deskripsi Produk</label>

                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            placeholder="Masukkan deskripsi produk..."
                        >{{ old('deskripsi') }}</textarea>

                        @error('deskripsi')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- GAMBAR --}}
                    <div class="form-group full">
                        <label for="gambar">Gambar Produk</label>

                        <input
                            type="file"
                            id="gambar"
                            name="gambar"
                            accept=".jpg,.jpeg,.png,.webp"
                            onchange="previewImage(event)"
                        >

                        <div class="help-text">
                            Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        </div>

                        @error('gambar')
                            <p class="field-error">{{ $message }}</p>
                        @enderror

                        <div class="image-preview" id="imagePreview">
                            <img
                                id="preview"
                                src=""
                                alt="Preview gambar produk"
                            >
                        </div>
                    </div>

                </div>

                {{-- ACTION BUTTONS --}}
                <div class="form-actions">
                    <a
                        href="{{ route('admin.products.index') }}"
                        class="btn btn-secondary"
                    >
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Simpan Produk
                    </button>
                </div>

            </form>
        </div>

    </main>

    {{-- PREVIEW GAMBAR --}}
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
                preview.src = '';
                previewContainer.style.display = 'none';
            }
        }
    </script>

</body>
</html>
