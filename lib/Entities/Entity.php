<?php

namespace Fundevogel\Mastodon\Entities;


/**
 * Class Entity
 *
 * Base class for API entities
 */
abstract class Entity
{
    /**
     * Raw data
     *
     * @var array
     */
    public $data;


    /**
     * Constructor
     */
    public function __construct(array $data)
    {
        # Store raw data
        $this->data = $data;
    }
}
