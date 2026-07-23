<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Pesan error kustom (Bahasa Indonesia) untuk validasi batas ukuran berkas maksimal 2Mb,
     * dipakai di semua form yang punya upload gambar/berkas supaya pesannya konsisten & jelas.
     * Termasuk pesan untuk kasus berkas gagal diupload karena melebihi batas PHP itu sendiri
     * (upload_max_filesize), supaya tetap ada peringatan yang jelas dan bukan halaman error mentah.
     *
     * @param  array<int, string>  $fields
     * @return array<string, string>
     */
    protected function maxFileSizeMessages(array $fields): array
    {
        return collect($fields)
            ->flatMap(fn (string $field) => [
                $field.'.max' => 'Ukuran file tidak boleh lebih dari 2Mb.',
                $field.'.uploaded' => 'File gagal diupload, kemungkinan ukurannya melebihi batas server.',
            ])
            ->all();
    }

    /**
     * Cek lebih dulu apakah ada berkas yang ditolak PHP sendiri (misalnya melebihi
     * upload_max_filesize di php.ini, defaultnya cuma 2MB — lebih kecil dari batas 2Mb
     * yang kita tetapkan di validasi). Kasus ini tidak selalu tertangkap rapi oleh rule
     * validasi biasa, jadi dicek manual di sini supaya penggunanya SELALU dapat peringatan
     * yang jelas, bukannya perubahan yang gagal tersimpan tanpa keterangan apa pun.
     *
     * @param  array<int, string>  $fields
     */
    protected function rejectFailedUploads(Request $request, array $fields): ?RedirectResponse
    {
        foreach ($fields as $field) {
            $file = $request->file($field);

            if ($file === null || $file->getError() === UPLOAD_ERR_OK) {
                continue;
            }

            $pesan = match ($file->getError()) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Ukuran file yang diupload terlalu besar (maksimal 2Mb). Silakan pilih file yang lebih kecil.',
                UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian, kemungkinan koneksi terputus. Silakan coba lagi.',
                default => 'File gagal diupload. Silakan coba lagi dengan file lain.',
            };

            return back()->withInput($request->except($fields))->with('error', $pesan);
        }

        return null;
    }
}
