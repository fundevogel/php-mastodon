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


    public function __construct(\Fundevogel\Mastodon\Api $api)
    {
        $this->api = $api;
    }
}
