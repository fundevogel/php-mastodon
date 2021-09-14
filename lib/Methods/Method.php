<?php

namespace Fundevogel\Mastodon\Methods;

use Fundevogel\Mastodon\Api;


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
        # Supply access to API
        $this->api = $api;
    }
}
