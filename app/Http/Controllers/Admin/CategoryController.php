<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Kategori::withCount('produk')
            ->orderBy('nama_kategori')
            ->get();

        $totalKategori = $categories->count();

        return view('admin.categories.index', compact(
            'categories',
            'totalKategori'
        ));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:kategori,nama_kategori'],
            'deskripsi'     => ['nullable', 'string', 'max:500'],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah digunakan.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
            'deskripsi.max'          => 'Deskripsi maksimal 500 karakter.',
        ]);

        DB::transaction(function () use ($data) {
            $category = Kategori::create($data);

            $this->writeAuditLog(
                action: 'create',
                category: $category,
                description: 'Menambahkan kategori: ' . $category->nama_kategori,
                oldValues: null,
                newValues: [
                    'nama_kategori' => $category->nama_kategori,
                    'deskripsi'     => $category->deskripsi,
                ],
            );
        });

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Kategori $category)
    {
        $data = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kategori', 'nama_kategori')->ignore($category->id_kategori, 'id_kategori'),
            ],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah digunakan.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
            'deskripsi.max'          => 'Deskripsi maksimal 500 karakter.',
        ]);

        DB::transaction(function () use ($category, $data) {
            $oldValues = [
                'nama_kategori' => $category->nama_kategori,
                'deskripsi'     => $category->deskripsi,
            ];

            $category->update($data);

            $this->writeAuditLog(
                action: 'update',
                category: $category,
                description: 'Memperbarui kategori: ' . $category->nama_kategori,
                oldValues: $oldValues,
                newValues: [
                    'nama_kategori' => $category->nama_kategori,
                    'deskripsi'     => $category->deskripsi,
                ],
            );
        });

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $category)
    {
        if ($category->produk()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }

        DB::transaction(function () use ($category) {
            $oldValues = [
                'nama_kategori' => $category->nama_kategori,
                'deskripsi'     => $category->deskripsi,
            ];

            $this->writeAuditLog(
                action: 'delete',
                category: $category,
                description: 'Menghapus kategori: ' . $category->nama_kategori,
                oldValues: $oldValues,
                newValues: null,
            );

            $category->delete();
        });

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Menyimpan aktivitas Admin ke audit log.
     */
    private function writeAuditLog(
        string $action,
        Kategori $category,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
    ): void {
        $actor = Auth::guard('admin')->user();

        AuditLog::create([
            'actor_type'  => 'admin',
            'actor_id'    => $actor?->getAuthIdentifier(),
            'actor_name'  => $actor?->nama
                ?? $actor?->name
                ?? 'Admin',
            'action'      => $action,
            'target_type' => 'Kategori',
            'target_id'   => (string) $category->id_kategori,
            'description' => $description,
            'old_values'  => $oldValues,
            'new_values'  => $newValues,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'status'      => 'success',
        ]);
    }
}