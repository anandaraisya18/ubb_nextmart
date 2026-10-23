<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AuditLog;
use App\Models\ManagementGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('group')
            ->latest('created_at')
            ->get();

        return view('superadmin.admin.index', compact('admins'));
    }

    public function create()
    {
        $groups = ManagementGroup::orderBy('nama_group')->get();

        return view('superadmin.admin.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admin,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'id_group' => [
                'required',
                'integer',
                'exists:management_group,id_group',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $admin = Admin::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'id_group' => $validated['id_group'],
            ]);

            $this->writeAuditLog(
                action: 'create',
                admin: $admin,
                description: 'Membuat akun Admin: ' . $admin->nama,
                oldValues: null,
                newValues: [
                    'nama' => $admin->nama,
                    'email' => $admin->email,
                    'id_group' => $admin->id_group,
                ],
            );
        });

        return redirect()
            ->route('superadmin.admin.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);

        $groups = ManagementGroup::orderBy('nama_group')->get();

        return view('superadmin.admin.edit', compact('admin', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:admin,email,' . $admin->id_admin . ',id_admin',
            ],
            'id_group' => [
                'required',
                'integer',
                'exists:management_group,id_group',
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($admin, $validated) {
            $oldValues = [
                'nama' => $admin->nama,
                'email' => $admin->email,
                'id_group' => $admin->id_group,
            ];

            $passwordChanged = !empty($validated['password']);

            $admin->nama = $validated['nama'];
            $admin->email = $validated['email'];
            $admin->id_group = $validated['id_group'];

            if ($passwordChanged) {
                $admin->password = Hash::make($validated['password']);
            }

            $admin->save();

            $newValues = [
                'nama' => $admin->nama,
                'email' => $admin->email,
                'id_group' => $admin->id_group,
                'password_changed' => $passwordChanged,
            ];

            $this->writeAuditLog(
                action: 'update',
                admin: $admin,
                description: 'Memperbarui akun Admin: ' . $admin->nama
                    . ($passwordChanged ? ' (termasuk perubahan password)' : ''),
                oldValues: $oldValues,
                newValues: $newValues,
            );
        });

        return redirect()
            ->route('superadmin.admin.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    public function access($id)
    {
        $admin = Admin::findOrFail($id);

        return view('superadmin.admin.access', compact('admin'));
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        DB::transaction(function () use ($admin) {
            $oldValues = [
                'nama' => $admin->nama,
                'email' => $admin->email,
                'id_group' => $admin->id_group,
            ];

            $this->writeAuditLog(
                action: 'delete',
                admin: $admin,
                description: 'Menghapus akun Admin: '
                    . $admin->nama . ' (' . $admin->email . ')',
                oldValues: $oldValues,
                newValues: null,
            );

            $admin->delete();
        });

        return redirect()
            ->route('superadmin.admin.index')
            ->with('success', 'Akun Admin berhasil dihapus.');
    }

    /**
     * Menyimpan aktivitas Superadmin ke audit log.
     */
    private function writeAuditLog(
        string $action,
        Admin $admin,
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
            'target_type' => 'Admin',
            'target_id' => (string) $admin->id_admin,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => 'success',
        ]);
    }
}