<?php

namespace Flatcore\Entities;

abstract class Model
{
    // Maps to a folder with *.md files

    protected $folder;

    /**
     * Represents the name without extension
     *
     * @var string|null $fileName
     */
    protected $fileName = null;

    /**
     * Represents the full name and path
     *
     * @var string|null $fullFile
     */
    protected $fullFile = null;

    /**
     * @var string $extension Extension of the files
     */
    protected $extension = 'md';

    /**
     * @var string
     */
    protected $properties = [];

    /**
     * @var string
     */
    protected $body = '';

    /**
     * @var string
     */
    protected $required = [];

    public function getRaw()
    {

    }
}
