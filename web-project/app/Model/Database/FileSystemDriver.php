<?php

declare(strict_types=1);

namespace App\Model\Database;

use Nette\IOException;
use Nette\Utils\FileSystem;

class FileSystemDriver
{

    public function __construct(
        private readonly string $path
    ) {

    }

    public function incrementReadCounter(string $id): void
    {
        $path = $this->getCounterPath($id);

        // ensure directory exists
        $dir = dirname($path);
        try {
            FileSystem::createDir($dir);
        } catch (IOException $e) {
           throw new FileSystemException('Unable to create directory ' . $dir, previous: $e);
        }

        try {
            $file = new \SplFileObject($path, 'c+');
        } catch (\RuntimeException $e) {
            throw new FileSystemException('Unable to open file ' . $path, previous: $e);
        }

        try {
            if (!$file->flock(LOCK_EX)) {
                throw new FileSystemException('Unable to lock file ' . $path);
            }

            // Čtení obsahu
            $contents = $this->readFileContents($file);
            $count = 0;
            if ($contents !== '' && trim($contents) !== '') {
                $count = (int)trim($contents);
            }

            $count++;
            $data = (string)$count . PHP_EOL;
            $this->rewriteFile($file, $data);

            $file->flock(LOCK_UN);
        } finally {
            unset($file);
            // get sure to close file even if exception occurs
        }
    }

    protected function getCounterPath(string $id): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $id . '-count.dat';
    }

    protected function rewriteFile(\SplFileObject $file, string $data): void
    {
        if(!$file->ftruncate(0)) {
            throw new FileSystemException('Unable to truncate file');
        }
        $file->rewind();

        $bytes = $file->fwrite($data);
        if ($bytes === false) {
            throw new FileSystemException('Unable to write to file');
        }

        if ($bytes !== strlen($data)) {
            throw new FileSystemException('Unable to write whole data to file');
        }

        if(!$file->fflush()) {
            throw new FileSystemException('Unable to flush file');
        };
    }

    /**
     * @throws FileSystemException
     */
    private function readFileContents(\SplFileObject $file): string
    {
        $file->rewind();
        try {
            $line = $file->fgets();
        } catch (\RuntimeException $e) {
            throw new FileSystemException('Unable to read file', previous: $e);
        }
        return $line;
    }
}

class FileSystemException extends \RuntimeException
{

}
