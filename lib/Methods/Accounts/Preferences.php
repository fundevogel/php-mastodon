<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Preferences
 *
 * Preferred common behaviors to be shared across clients
 */
class Preferences extends Method
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
