<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Favourites
 *
 * View your favourites
 *
 * @see https://docs.joinmastodon.org/methods/accounts/favourites
 */
class Favourites extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'favourites';


    /**
     * Favourited statuses
     *
     * Statuses the user has favourited
     *
     * @param int $limit Maximum number of results
     * @param string $maxID Return results older than ID
     * @param string $sinceID Return results newer than ID
     *
     * @return array Array of Status
     */
    public function get(int $limit = 20, string $minID = '', string $maxID = ''): array
    {
        $endpoint = "{$this->endpoint}";

        return array_map(function () {
            return new \Fundevogel\Mastodon\Entities\Status($data);
        }, $this->api->get($endpoint, [
            'limit'  => $limit,
            'min_id' => $minID,
            'max_id' => $maxID,
        ]));
    }
}
