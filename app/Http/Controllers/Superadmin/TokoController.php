<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use App\Models\ManagementGroup;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TokoController extends Controller
{
    /**
     * Daftar semua toko.
     */
    public function index()
    {
        $stores = Toko::with('group')
            ->latest('created_at')
            ->get();

        return view('superadmin.toko.index', compact('stores'));
    }

    /**
     * Form tambah toko.
     */
    public function create()
    {
        $groups = ManagementGroup::where('status', 'aktif')
            ->orderBy('nama_group')
            ->get();

        return view('superadmin.toko.create', compact('groups'));
    }

    /**
     * Simpan toko baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_group'        => ['required', 'integer', 'exists:management_group,id_group'],
            'nama_toko'       => ['required', 'string', 'max:150'],
            'deskripsi'       => ['nullable', 'string'],
            'alamat'          => ['nullable', 'string', 'max:255'],
            'nomor_telepon'   => ['nullable', 'string', 'max:20'],
            'jam_operasional' => ['nullable', 'string', 'max:100'],
            'link_instagram'  => ['nullable', 'url', 'max:255'],
            'link_tiktok'     => ['nullable', 'url', 'max:255'],
        ]);

        DB::transaction(function () use ($validated) {
            $store = Toko::create($validated);

            $this->writeAuditLog(
                action: 'create',
                store: $store,
                description: 'Menambahkan toko: ' . $store->nama_toko,
                oldValues: null,
                newValues: $this->getStoreValues($store),
            );
        });

        return redirect()
            ->route('superadmin.toko.index')
            ->with('success', 'Toko berhasil ditambahkan.');
    }

    /**
     * Form edit toko.
     */
    public function edit($id)
    {
        $store = Toko::findOrFail($id);

        $groups = ManagementGroup::where('status', 'aktif')
            ->orderBy('nama_group')
            ->get();

        return view('superadmin.toko.edit', compact(
            'store',
            'groups'
        ));
    }

    /**
     * Update toko.
     */
    public function update(Request $request, $id)
    {
        $store = Toko::findOrFail($id);

        $validated = $request->validate([
            'id_group'        => ['required', 'integer', 'exists:management_group,id_group'],
            'nama_toko'       => ['required', 'string', 'max:150'],
            'deskripsi'       => ['nullable', 'string'],
            'alamat'          => ['nullable', 'string', 'max:255'],
            'nomor_telepon'   => ['nullable', 'string', 'max:20'],
            'jam_operasional' => ['nullable', 'string', 'max:100'],
            'link_instagram'  => ['nullable', 'url', 'max:255'],
            'link_tiktok'     => ['nullable', 'url', 'max:255'],
        ]);

        DB::transaction(function () use ($store, $validated) {
            $oldValues = $this->getStoreValues($store);

            $store->update($validated);

            $newValues = $this->getStoreValues($store->fresh());

            $this->writeAuditLog(
                action: 'update',
                store: $store,
                description: 'Memperbarui data toko: ' . $store->nama_toko,
                oldValues: $oldValues,
                newValues: $newValues,
            );
        });

        return redirect()
            ->route('superadmin.toko.index')
            ->with('success', 'Toko berhasil diperbarui.');
    }

    /**
     * Hapus toko.
     */
    public function destroy($id)
    {
        $store = Toko::findOrFail($id);

        DB::transaction(function () use ($store) {
            $oldValues = $this->getStoreValues($store);

            $this->writeAuditLog(
                action: 'delete',
                store: $store,
                description: 'Menghapus toko: ' . $store->nama_toko,
                oldValues: $oldValues,
                newValues: null,
            );

            $store->delete();
        });

        return redirect()
            ->route('superadmin.toko.index')
            ->with('success', 'Toko berhasil dihapus.');
    }

    /**
     * Mengambil data toko untuk audit log.
     */
    private function getStoreValues(Toko $store): array
    {
        return [
            'id_toko'         => $store->id_toko,
            'id_group'        => $store->id_group,
            'nama_toko'       => $store->nama_toko,
            'deskripsi'       => $store->deskripsi,
            'alamat'          => $store->alamat,
            'nomor_telepon'   => $store->nomor_telepon,
            'jam_operasional' => $store->jam_operasional,
            'link_instagram'  => $store->link_instagram,
            'link_tiktok'     => $store->link_tiktok,
        ];
    }

    /**
     * Menyimpan aktivitas Superadmin ke audit log.
     */
    private function writeAuditLog(
        string $action,
        Toko $store,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
    ): void {
        $actor = Auth::user();

        AuditLog::create([
            'actor_type'  => 'superadmin',
            'actor_id'    => $actor?->getAuthIdentifier(),
            'actor_name'  => $actor?->nama
                ?? $actor?->name
                ?? 'Superadmin',
            'action'      => $action,
            'target_type' => 'Toko',
            'target_id'   => (string) $store->id_toko,
            'description' => $description,
            'old_values'  => $oldValues,
            'new_values'  => $newValues,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'status'      => 'success',
        ]);
    }
}
