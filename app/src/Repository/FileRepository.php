<?php

namespace App\Repository;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileRepository implements Repository
{
    public function __construct(
        protected string $fileFullPath,
        protected Filesystem $filesystem
    )
    {
    }

    public function all(): array
    {
        return explode(PHP_EOL, $this->readFile());
    }

    public function save(mixed $data)
    {
        $this->filesystem->appendToFile($this->fileFullPath, $data . PHP_EOL);
    }

    public function has(mixed $needle): bool
    {
        $data = $this->all();
        return in_array($needle, $data);
    }

    protected function readFile()
    {
        try {
            return file_get_contents($this->fileFullPath);
        } catch (\Exception $e) {
            throw new FileException($e);
        }
    }
}