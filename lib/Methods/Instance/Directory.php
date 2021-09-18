<?php

namespace Fundevogel\Mastodon\Methods\Instance;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Directory
 *
 * A directory of profiles that your website is aware of
 *
 * @see https://docs.joinmastodon.org/methods/instance/directory
 */
class Directory extends Method
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

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Account($data);
        }, $this->api->get($endpoint, [
            'offset' => $offset,
            'limit'  => $limit,
            'order'  => $order,
            'local'  => $local,
        ]));
    }
}
