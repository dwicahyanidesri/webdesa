<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\PerangkatDesa;
use App\Models\PotensiDesa;
use App\Models\ProfilDesa;
use App\Models\ProgramKerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    public function index()
    {
        $usedPaths = $this->usedFilePaths();
        $allPaths = collect(Storage::disk('public')->allFiles())
            ->reject(fn ($path) => str_ends_with($path, '.gitignore'));

        $files = $allPaths->map(function ($path) use ($usedPaths) {
            $size = Storage::disk('public')->size($path);
            $modified = Storage::disk('public')->lastModified($path);
            $isUsed = $usedPaths->contains($path);

            return [
                'path' => $path,
                'size' => $size,
                'size_formatted' => $this->formatBytes($size),
                'modified' => $modified,
                'modified_formatted' => \Illuminate\Support\Carbon::createFromTimestamp($modified)->translatedFormat('d M Y, H:i'),
                'is_image' => (bool) preg_match('/\.(jpe?g|png|gif|webp)$/i', $path),
                'is_used' => $isUsed,
                'status_label' => $isUsed ? 'Digunakan' : 'Tidak Digunakan',
            ];
        })
            // Berkas yang tidak dipakai ditaruh paling atas supaya langsung terlihat admin,
            // lalu diurutkan dari yang terbaru diubah.
            ->sortBy(fn ($file) => [$file['is_used'] ? 1 : 0, -$file['modified']])
            ->values();

        $orphans = $files->reject(fn ($file) => $file['is_used'])->values();

        $totalFiles = $files->count();
        $totalSize = $files->sum('size');
        $orphanSize = $orphans->sum('size');

        return view('admin.maintenance.index', [
            'files' => $files,
            'totalFiles' => $totalFiles,
            'totalSizeFormatted' => $this->formatBytes($totalSize),
            'orphanCount' => $orphans->count(),
            'orphanSizeFormatted' => $this->formatBytes($orphanSize),
        ]);
    }

    /**
     * Format ukuran berkas (bytes) jadi teks yang enak dibaca (KB/MB/GB).
     */
    private function formatBytes(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 KB';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $i = min((int) floor(log($bytes, 1024)), count($units) - 1);

        return round($bytes / (1024 ** $i), $i === 0 ? 0 : 1).' '.$units[$i];
    }

    public function destroyFile(Request $request): RedirectResponse
    {
        $request->validate(['path' => ['required', 'string']]);

        $path = $request->string('path')->toString();
        $usedPaths = $this->usedFilePaths();

        // Jaga-jaga: hanya boleh menghapus file yang benar-benar ada di disk public
        // dan sudah dipastikan tidak dipakai oleh data manapun.
        if (! Storage::disk('public')->exists($path) || $usedPaths->contains($path)) {
            return redirect()->route('admin.maintenance.index')
                ->with('error', 'File tidak ditemukan atau masih dipakai oleh data lain.');
        }

        Storage::disk('public')->delete($path);

        return redirect()->route('admin.maintenance.index')->with('success', 'File berhasil dihapus.');
    }

    public function destroyOrphans(): RedirectResponse
    {
        $usedPaths = $this->usedFilePaths();
        $allFiles = collect(Storage::disk('public')->allFiles())
            ->reject(fn ($path) => str_ends_with($path, '.gitignore'));

        $orphanPaths = $allFiles->diff($usedPaths)->values();

        foreach ($orphanPaths as $path) {
            Storage::disk('public')->delete($path);
        }

        return redirect()->route('admin.maintenance.index')
            ->with('success', $orphanPaths->count().' file tidak terpakai berhasil dihapus.');
    }

    public function clearCache(): RedirectResponse
    {
        Artisan::call('optimize:clear');

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Cache aplikasi (config, route, view, cache) berhasil dibersihkan.');
    }

    /**
     * Kumpulkan semua path file yang masih direferensikan oleh data di database,
     * supaya tidak ada file yang sedang dipakai ikut terhapus.
     */
    private function usedFilePaths(): Collection
    {
        return collect()
            ->merge(ProfilDesa::query()->pluck('logo'))
            ->merge(ProfilDesa::query()->pluck('foto_hero'))
            ->merge(ProfilDesa::query()->pluck('foto_desa'))
            ->merge(PotensiDesa::query()->pluck('gambar'))
            ->merge(PerangkatDesa::query()->pluck('foto'))
            ->merge(ProgramKerja::query()->pluck('dokumentasi'))
            ->merge(BeritaAcara::query()->pluck('gambar'))
            ->filter()
            ->unique()
            ->values();
    }
}
