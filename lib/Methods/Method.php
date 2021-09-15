<?php

namespace Fundevogel\Mastodon\Methods;


/**
 * Class Method
 */
abstract Class Method
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
