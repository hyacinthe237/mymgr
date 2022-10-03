<?php

namespace App\Utilities;

trait Uploads
{

    /**
     * Boot function from laravel.
     */
    protected function upload($file, $directory)
    {
        $name = $file->getClientOriginalName();
        $filename = microtime(true) . '_' . $name;
        $path = public_path() . $directory;
        $file->move($path, $filename);
        return (object) ['name' => $name, 'link' => $directory . $filename];
    }
}
