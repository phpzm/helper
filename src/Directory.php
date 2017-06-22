<?php

namespace Simples\Helper;

use FilesystemIterator;
use DirectoryIterator;
use Simples\Error\SimplesRunTimeError;

/**
 * Class Directory
 * @package Simples\Helper
 */
abstract class Directory
{
    /**
     * @param string $dir
     * @return int
     */
    public static function count(string $dir): int
    {
        return (int)iterator_count(new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS));
    }

    /**
     * @param string $dir
     * @return bool
     */
    public static function exists(string $dir): bool
    {
        return is_dir($dir);
    }

    /**
     * @param string $dir
     * @return bool
     */
    public static function make(string $dir): bool
    {
        $make = is_dir($dir);
        if (!$make) {
            $make = mkdir($dir, 0755, true);
        }
        return $make;
    }

    /**
     * @param string $dir
     * @return bool
     */
    public static function remove(string $dir): bool
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? static::remove("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    /**
     * @param string $source
     * @param string $target
     * @return bool
     */
    public static function rename(string $source, string $target): bool
    {
        return rename($source, $target);
    }

    /**
     * @param string $dir
     * @return array
     * @throws SimplesRunTimeError
     */
    public static function getFiles(string $dir): array
    {
        $files = [];
        if (!static::exists($dir)) {
            throw new SimplesRunTimeError("Directory `{$dir}` not found");
        }
        foreach (new DirectoryIterator($dir) as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }
            $files[] = $fileInfo->getRealPath();
        }
        return $files;
    }
}
