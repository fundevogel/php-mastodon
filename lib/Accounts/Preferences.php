<?php

namespace Fundevogel\Mastodon\Accounts;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Preferences
 *
 * Preferred common behaviors to be shared across clients
 */
class Preferences extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'preferences';


    /**
     * Views user preferences
     *
     * @return array
     */
    public function get(): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint);
    }
}
