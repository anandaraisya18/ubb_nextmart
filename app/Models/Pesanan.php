<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;

    protected $fillable = [
        'no_resi', 'tipe_transaksi', 'jenis_pengambilan', 'tanggal_pesanan',
        'subtotal', 'total', 'status_pesanan', 'id_pelanggan',
        'total_awal', 'potongan_cetak', 'selesai_otomatis',
    ];

    protected $casts = [
        'tanggal_pesanan'  => 'datetime',
        'subtotal'         => 'integer',
        'total'            => 'integer',
        'total_awal'       => 'float',
        'potongan_cetak'   => 'float',
        'selesai_otomatis' => 'boolean',
    ];

    public const STATUS = [
        'menunggu_pembayaran' => 'Menunggu Pembayaran',
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'diproses'            => 'Diproses',
        'siap_diambil'        => 'Siap Diambil',
        'selesai'             => 'Selesai',
        'dibatalkan'          => 'Dibatalkan',
    ];

    public const TIPE = [
        'online'  => 'Online',
        'offline' => 'Offline',
    ];

    public const PENGAMBILAN = [
        'ambil_di_tempat' => 'Ambil di Tempat',
        'diantar'         => 'Diantar',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_pesanan';
    }

    #[Scope]
    protected function milikGroup(Builder $query): void
    {
        $query->whereHas('detail.produk', fn ($p) => $p->milikGroup());
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Semua file cetak milik pesanan ini (lewat detail_pesanan).
     */
    public function prints(): HasManyThrough
    {
        return $this->hasManyThrough(
            DetailPrint::class,
            DetailPesanan::class,
            'id_pesanan', // FK di detail_pesanan -> pesanan
            'id_detail',  // FK di detail_prints -> detail_pesanan
            'id_pesanan', // PK lokal di pesanan
            'id_detail'   // PK lokal di detail_pesanan
        );
    }

    /**
     * True jika masih ada file cetak yang menunggu verifikasi admin.
     * File 'perlu_revisi' (ditolak) tidak menghalangi karena sudah final.
     */
    public function adaPrintBelumDisetujui(): bool
    {
        return $this->prints()
            ->where('status_verifikasi', 'menunggu_verifikasi')
            ->exists();
    }

    public function batalkan(): bool
    {
        return DB::transaction(function () {
            $order = static::whereKey($this->getKey())->lockForUpdate()->first();

            if (! $order || $order->status_pesanan === 'dibatalkan') {
                return false;
            }

            foreach ($order->detail as $detail) {
                Produk::where('id_produk', $detail->id_produk)
                    ->increment('stok', $detail->jumlah);
            }

            $order->status_pesanan = 'dibatalkan';
            $order->save();

            $this->status_pesanan = 'dibatalkan';

            return true;
        });
    }

    /**
     * Hitung ulang potongan dari status semua file cetak.
     * Aman dipanggil berulang (idempotent).
     */
    public function hitungUlangPotongan(): void
    {
        $this->load('detail.detailPrints');

        $prints  = $this->detail->flatMap(fn ($d) => $d->detailPrints);
        $ditolak = $prints->where('status_verifikasi', 'perlu_revisi');

        $totalAwal = (float) ($this->total_awal ?? $this->total);
        $potongan  = min((float) $ditolak->sum('total_harga'), $totalAwal);

        // Semua item di pesanan adalah item cetak dan semua filenya ditolak
        $semuaDitolak = $this->detail->isNotEmpty()
            && $this->detail->every(fn ($d) =>
                $d->detailPrints->isNotEmpty()
                && $d->detailPrints->every(fn ($p) => $p->status_verifikasi === 'perlu_revisi')
            );

        $data = [
            'total_awal'     => $totalAwal,
            'potongan_cetak' => $potongan,
            'total'          => $totalAwal - $potongan,
        ];

        if ($semuaDitolak && ! in_array($this->status_pesanan, ['selesai', 'dibatalkan'])) {
            $data['status_pesanan']   = 'selesai';
            $data['selesai_otomatis'] = true;
        } elseif (! $semuaDitolak && $this->selesai_otomatis) {
            $data['status_pesanan']   = 'diproses';
            $data['selesai_otomatis'] = false;
        }

        $this->update($data);
    }
}