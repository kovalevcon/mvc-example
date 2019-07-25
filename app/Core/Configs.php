<?php
declare(strict_types=1);
namespace App\Core;

use FilesystemIterator;
use RegexIterator;
use stdClass;

/**
 * Class Configs
 *
 * @package App\Core
 */
class Configs
{
    /** @var array $configs */
    protected $configs = [];

    /**
     * Configs constructor.
     *
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        $path = realpath(__DIR__ . $dir);

        /** @var FilesystemIterator $iterator */
        $iterator = new FilesystemIterator($path);
        /** @var RegexIterator $filter */
        $filter = new RegexIterator($iterator, '/(.php)$/');
        foreach ($filter as $entry) {
            $file = $entry->getFilename();
            $this->configs[pathinfo($file, PATHINFO_FILENAME)] = require "{$path}/{$file}";
        }
    }

    /**
     * Get from config
     *
     * @param string $key
     * @return stdClass|null
     */
    public function get(string $key): ?stdClass
    {
        return isset($this->configs[$key]) ? json_decode(json_encode($this->configs[$key])) : null;
    }
}
