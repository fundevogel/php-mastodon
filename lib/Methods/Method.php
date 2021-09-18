<?php

namespace Fundevogel\Mastodon\Methods;


/**
 * Class Method
 *
 * Base class for API methods
 */
abstract class Method
{
    /**
     * API gateway
     *
     * @var \Fundevogel\Mastodon\Api
     */
    protected $api;


    /**
     * Constructor
     */
    public function __construct(\Fundevogel\Mastodon\Api $api)
    {
        # Relay API access
        $this->api = $api;
    }
}
