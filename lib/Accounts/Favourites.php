<?php

namespace Fundevogel\Mastodon\Accounts;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Favourites
 *
 * View your favourites
 */
class Favourites extends ApiMethod
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

        return $this->api->get($endpoint, [
            'limit'  => $limit,
            'min_id' => $minID,
            'max_id' => $maxID,
        ]);
    }
}
