<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Preferences
 *
 * Preferred common behaviors to be shared across clients
 *
 * @see https://docs.joinmastodon.org/methods/accounts/preferences
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
     * Preferences defined by the user in their account settings
     *
     * @return \Fundevogel\Mastodon\Entities\Preferences Preferences by key and value
     */
    public function get(): \Fundevogel\Mastodon\Entities\Preferences
    {
        $endpoint = "{$this->endpoint}";

        return new \Fundevogel\Mastodon\Entities\Preferences($this->api->get($endpoint));
    }
}
