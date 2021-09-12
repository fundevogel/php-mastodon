<?php

namespace Fundevogel\Mastodon\Instance;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Directory
 *
 * A directory of profiles that your website is aware of
 */
class Directory extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'directory';


    /**
     * View profile directory
     *
     * List accounts visible in the directory
     *
     * @param int $offset How many accounts to skip before returning results
     * @param int $limit How many accounts to load
     * @param string $order `active` to sort by most recently posted statuses or `new` to sort by most recently created profiles
     * @param bool $local Only return local accounts
     *
     * @return array Array of Account
     */
    public function get(int $offset = 0, int $limit = 40, string $order = 'active', bool $local = true): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'offset' => $offset,
            'limit'  => $limit,
            'order'  => $order,
            'local'  => $local,
        ]);
    }
}
