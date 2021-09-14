<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Blocks
 *
 * View your blocks
 */
class Blocks extends Method
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
