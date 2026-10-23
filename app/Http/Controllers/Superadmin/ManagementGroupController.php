<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\ManagementGroup;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagementGroupController extends Controller
{
    /**
     * Menampilkan daftar group operasional.
     */
    public function index()
    {
        $groups = ManagementGroup::with([
            'stores' => function ($query) {
                $query->orderBy('nama_toko');
            }
        ])
        ->orderBy('nama_group')
        ->get();

        return view('superadmin.group.index', compact('groups'));
    }

    /**
     * Form tambah group.
     */
    public function create()
    {
        return view('superadmin.group.create');
    }

    /**
     * Simpan group baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_group' => [
                'required',
                'string',
                'max:100',
            ],

            'status' => [
                'required',
                'string',
                'max:20',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $group = ManagementGroup::create($validated);

            $this->writeAuditLog(
                action: 'create',
                group: $group,
                description: 'Menambahkan group operasional: ' . $group->nama_group,
                oldValues: null,
                newValues: $this->getGroupValues($group),
            );
        });

        return redirect()
            ->route('superadmin.group.index')
            ->with('success', 'Group operasional berhasil ditambahkan.');
    }

    /**
     * Form edit group.
     */
    public function edit($id)
    {
        $group = ManagementGroup::findOrFail($id);

        return view('superadmin.group.edit', compact('group'));
    }

    /**
     * Update group.
     */
    public function update(Request $request, $id)
    {
        $group = ManagementGroup::findOrFail($id);

        $validated = $request->validate([
            'nama_group' => [
                'required',
                'string',
                'max:100',
            ],

            'status' => [
                'required',
                'string',
                'max:20',
            ],
        ]);

        DB::transaction(function () use ($group, $validated) {
            $oldValues = $this->getGroupValues($group);

            $group->update($validated);

            $newValues = $this->getGroupValues($group->fresh());

            $this->writeAuditLog(
                action: 'update',
                group: $group,
                description: 'Memperbarui group operasional: ' . $group->nama_group,
                oldValues: $oldValues,
                newValues: $newValues,
            );
        });

        return redirect()
            ->route('superadmin.group.index')
            ->with('success', 'Group operasional berhasil diperbarui.');
    }

    /**
     * Hapus group.
     */
    public function destroy($id)
    {
        $group = ManagementGroup::findOrFail($id);

        DB::transaction(function () use ($group) {
            $oldValues = $this->getGroupValues($group);

            // Catat penghapusan sebelum group dihapus.
            $this->writeAuditLog(
                action: 'delete',
                group: $group,
                description: 'Menghapus group operasional: ' . $group->nama_group,
                oldValues: $oldValues,
                newValues: null,
            );

            // Lepaskan relasi toko terlebih dahulu.
            $group->stores()->update([
                'id_group' => null,
            ]);

            $group->delete();
        });

        return redirect()
            ->route('superadmin.group.index')
            ->with('success', 'Group operasional berhasil dihapus.');
    }

    /**
     * Mengambil data group untuk audit log.
     */
    private function getGroupValues(ManagementGroup $group): array
    {
        return [
            'id_group' => $group->id_group,
            'nama_group' => $group->nama_group,
            'status' => $group->status,
        ];
    }

    /**
     * Menyimpan aktivitas Superadmin ke audit log.
     */
    private function writeAuditLog(
        string $action,
        ManagementGroup $group,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
    ): void {
        $actor = Auth::user();

        AuditLog::create([
            'actor_type' => 'superadmin',
            'actor_id' => $actor?->getAuthIdentifier(),
            'actor_name' => $actor?->nama
                ?? $actor?->name
                ?? 'Superadmin',
            'action' => $action,
            'target_type' => 'ManagementGroup',
            'target_id' => (string) $group->id_group,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => 'success',
        ]);
    }
}
