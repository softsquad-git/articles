<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use \Exception;

class Upload
{
    /**
     * @param string $src
     * @param $file
     * @return string
     * @throws Exception
     */
    public static function singleFile(string $src, $file)
    {
        try {
            $fileName = md5(time() . Str::random(32)) . '.' . $file->getClientOriginalExtension();
            $file->move($src, $fileName);
            return $fileName;
        } catch (Exception $e) {
            throw new Exception('Upload file error');
        }
    }
}
