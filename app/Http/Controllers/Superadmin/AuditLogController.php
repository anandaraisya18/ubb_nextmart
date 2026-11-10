<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuditLogController extends Controller
{
    /**
     * Menampilkan audit log beserta filter dan pagination.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'actor' => ['nullable', 'string', 'max:100'],
            'action' => [
                'nullable',
                'string',
                'in:create,update,delete,access,login,logout',
            ],
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => [
                'nullable',
                'date_format:Y-m-d',
                'after_or_equal:from',
                'before_or_equal:today',
            ],
        ], [
            'actor.max' => 'Nama aktor maksimal 100 karakter.',
            'action.in' => 'Jenis aktivitas tidak valid.',
            'from.date_format' => 'Format tanggal awal tidak valid.',
            'to.date_format' => 'Format tanggal akhir tidak valid.',
            'to.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal awal.',
            'to.before_or_equal' => 'Tanggal akhir tidak boleh melebihi hari ini.',
        ]);

        // Query dasar audit log.
        $query = AuditLog::query();

        // Filter berdasarkan nama aktor.
        if (!empty($validated['actor'])) {
            $actor = trim($validated['actor']);

            $query->where('actor_name', 'like', '%' . $actor . '%');
        }

        // Filter berdasarkan jenis aktivitas.
        if (!empty($validated['action'])) {
            $query->where('action', $validated['action']);
        }

        // Filter dari tanggal tertentu.
        if (!empty($validated['from'])) {
            $query->whereDate('created_at', '>=', $validated['from']);
        }

        // Filter sampai tanggal tertentu.
        if (!empty($validated['to'])) {
            $query->whereDate('created_at', '<=', $validated['to']);
        }

        // Urutkan dari aktivitas terbaru.
        $logs = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('superadmin.audit.index', compact('logs'));
    }
}
