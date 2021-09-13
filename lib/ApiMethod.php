<?php

namespace Fundevogel\Mastodon;

use Fundevogel\Mastodon\Api;


/**
 * Class ApiMethod
 */
abstract Class ApiMethod
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
