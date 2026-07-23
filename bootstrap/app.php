<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // Kalau berkas yang diupload melebihi batas server (post_max_size di php.ini),
        // jangan tampilkan halaman error mentah — arahkan balik dengan peringatan yang jelas.
        $exceptions->render(function (PostTooLargeException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Berkas yang diupload terlalu besar. Maksimal ukuran berkas adalah 2Mb.',
                ], 413);
            }

            return back()
                ->withInput($request->except(['file', 'logo', 'foto_hero', 'foto_desa', 'gambar', 'foto', 'dokumentasi']))
                ->with('error', 'Berkas yang diupload terlalu besar. Maksimal ukuran berkas adalah 2Mb.');
        });
    })->create();
