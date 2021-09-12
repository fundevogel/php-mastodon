<?php

namespace Fundevogel\Mastodon\Accounts;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Blocks
 *
 * View your blocks
 */
class Blocks extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'blocks';


    /**
     * Gets blocked users
     *
     * @param string $maxID Return results older than ID
     * @param string $sinceID Return results newer than ID
     * @param int $limit Maximum number of results
     * @return array
     */
    public function get(string $maxID = '', string $sinceID = '', int $limit = 40): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'max_id'   => $maxID,
            'since_id' => $sinceID,
            'limit'    => $limit,
        ]);
    }
}
