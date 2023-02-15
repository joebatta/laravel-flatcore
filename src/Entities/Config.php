<?php

namespace Flatcore\Entities;

use Arr;
use ReflectionClass;
use Str;
use Symfony\Component\Yaml\Yaml;

abstract class Config
{
    /**
     * @var string $extension Extension of the files
     */
    protected string $extension = 'yml';

    /**
     * Represents the name without extension
     *
     * @var string|null $fileName
     */
    protected ?string $fileName = null;

    /**
     * Represents the full name and path
     *
     * @var string|null $fullFile
     */
    protected ?string $fullFile = null;

    /**
     * Holds the raw content of the file
     *
     * @var string|null $contents
     */
    protected ?string $contents = null;

    protected array $dataKeys = [];
    protected array $data = [];

    public function __construct()
    {
        $reflect = new ReflectionClass($this);
        $this->fileName = Str::slug($reflect->getShortName());
        $this->fullFile = $this->getConfigFile();

        $this->getRawContents();
        $this->data = Yaml::parse($this->contents);
    }

    public function getRawContents(): string
    {
        if (is_null($this->contents)) {
            $this->contents = file_get_contents($this->fullFile);
        }
        return $this->contents;
    }


    public function getConfigFile()
    {
        $configFolder = config('flatcore.config_path');
        return join(DIRECTORY_SEPARATOR, [$configFolder, $this->fileName . "." . $this->extension]);
    }

    public static function load(): Config
    {
        return (new static);
    }

    public function set(string $key, mixed $value)
    {
        if (Str::contains('.', $key)) {
            $this->setViaDots($key, $value);
        } else {
            $this->data[$key] = $value;
        }
    }

    private function setViaDots(string $key, mixed $value)
    {
        $dataDots = Arr::dot($this->data);
        $dataDots[$key] = $value;
        $this->data = Arr::undot($dataDots);
    }

    public function save()
    {

    }

    public function get(string $key, mixed $default = null, bool $dot = false)
    {
        if ($dot) {
            $value = Arr::dot($this->data)[$key] ?? $default;
        } else {
            $value = $this->data[$key] ?? $default;
        }

        return $value;
    }
}
