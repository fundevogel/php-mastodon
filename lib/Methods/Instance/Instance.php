<?php

namespace Fundevogel\Mastodon\Methods\Instance;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Instance
 *
 * Informational endpoint to discover information about a Mastodon website
 */
class Instance extends Method
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
     * @return \Fundevogel\Mastodon\Entities\Instance Instance
     */
    public function get(): \Fundevogel\Mastodon\Entities\Instance
    {
        $endpoint = "{$this->endpoint}";

        return new \Fundevogel\Mastodon\Entities\Instance($this->api->get($endpoint));
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

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Activity($data);
        }, $this->api->post($endpoint));
    }
}
