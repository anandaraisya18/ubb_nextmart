<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Smalot\PdfParser\Parser;
use Throwable;
use ZipArchive;

class PageCounter
{
    /**
     * Hitung jumlah halaman. Return null jika tidak bisa dideteksi.
     */
    public static function count(UploadedFile $file): ?int
    {
        $ext  = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        try {
            $jumlah = match ($ext) {
                'pdf'               => self::pdf($path),
                'pptx'              => self::pptx($path),
                'docx'              => self::docx($path),
                'jpg', 'jpeg', 'png' => 1,
                default             => null,
            };
        } catch (Throwable $e) {
            return null;
        }

        return ($jumlah && $jumlah > 0) ? $jumlah : null;
    }

    private static function pdf(string $path): int
    {
        return count((new Parser())->parseFile($path)->getPages());
    }

    private static function pptx(string $path): ?int
    {
        $zip = new ZipArchive();

        if ($zip->open($path) !== true) {
            return null;
        }

        $jumlah = 0;

        for ($i = 0; $i < $zip->numFiles; $i++) {
            if (preg_match('#^ppt/slides/slide\d+\.xml$#', $zip->getNameIndex($i))) {
                $jumlah++;
            }
        }

        $zip->close();

        return $jumlah;
    }

    private static function docx(string $path): ?int
    {
        $zip = new ZipArchive();

        if ($zip->open($path) !== true) {
            return null;
        }

        $xml = $zip->getFromName('docProps/app.xml');
        $zip->close();

        if ($xml && preg_match('#<Pages>(\d+)</Pages>#', $xml, $m)) {
            return (int) $m[1];
        }

        return null;
    }
}