<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Mutes
 *
 * View your mutes
 */
class Mutes extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'mutes';


    /**
     * Muted accounts
     *
     * Accounts the user has muted
     *
     * @param int $limit Maximum number of results to return per page
     * @param string $maxID Return results older than ID
     * @param string $sinceID Return results newer than ID
     *
     * @return array Array of Account
     */
    public function get(int $limit = 40, string $maxID = '', string $sinceID = ''): array
    {
        $endpoint = "{$this->endpoint}";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Account($data);
        }, $this->api->get($endpoint, [
            'limit'    => $limit,
            'max_id'   => $maxID,
            'since_id' => $sinceID,
        ]));
    }
}
