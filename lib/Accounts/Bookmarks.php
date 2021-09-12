<?php

namespace Fundevogel\Mastodon\Accounts;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Bookmarks
 *
 * View your bookmarks
 */
class Bookmarks extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'bookmarks';


    /**
     * Bookmarked statuses
     *
     * @param int $limit Max number of results to return
     * @param string $maxID Return results older than ID
     * @param string $sinceID Return results newer than ID
     * @param string $minID Return results immediately newer than ID
     *
     * @return array Statuses the user has bookmarked
     */
    public function get(int $limit = 20, string $maxID = '', string $sinceID = '', string $minID = ''): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'limit'    => $limit,
            'max_id'   => $maxID,
            'since_id' => $sinceID,
            'min_id'   => $minID,
        ]);
    }
}
