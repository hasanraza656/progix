<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/** Stores uploads straight into /public/uploads (no storage:link needed). */
class Uploader
{
    public const MIMES = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    public static function image(UploadedFile $file, string $folder = 'blog'): string
    {
        $dir = 'uploads/'.trim($folder, '/').'/'.date('Y/m');
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'image';
        $name = Str::limit($name, 60, '').'-'.Str::lower(Str::random(6)).'.'.strtolower($file->guessExtension() ?: $file->extension());

        if (! is_dir(public_path($dir))) {
            @mkdir(public_path($dir), 0775, true);
        }
        $file->move(public_path($dir), $name);

        return $dir.'/'.$name;
    }

    /** Delete a file previously stored by this class (never touches bundled assets). */
    public static function delete(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/') && ! str_contains($path, '..')) {
            @unlink(public_path($path));
        }
    }
}
