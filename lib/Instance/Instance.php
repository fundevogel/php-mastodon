<?php

namespace Fundevogel\Mastodon\Instance;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Instance
 *
 * Informational endpoint to discover information about a Mastodon website
 */
class Instance extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'instance';


    /**
     * Fetch instance
     *
     * Information about the server
     *
     * @return array Instance
     */
    public function get(): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint);
    }


    /**
     * List of connected domains
     *
     * Domains that this instance is aware of
     *
     * @return array Array of String
     */
    public function peers(): array
    {
        $endpoint = "{$this->endpoint}/peers";

        return $this->api->get($endpoint);
    }


    /**
     * Weekly activity
     *
     * Instance activity over the last 3 months, binned weekly
     *
     * @return array Array of Activity
     */
    public function activity(): array
    {
        $endpoint = "{$this->endpoint}/activity";

        return $this->api->post($endpoint);
    }
}
