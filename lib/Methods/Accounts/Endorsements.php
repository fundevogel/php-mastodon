<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Endorsements
 *
 * Feature other profiles on your own profile
 */
class Endorsements extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'endorsements';


    /**
     * Views currently featured profiles
     *
     * Accounts that the user is currently featuring on their profile
     *
     * @param int $limit Maximum number of results
     * @param string $maxID Return results older than ID
     * @param string $sinceID Return results newer than ID
     *
     * @return array Array of Account
     */
    public function get(int $limit = 40, string $maxID, string $sinceID): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'limit'    => $limit,
            'max_id'   => $maxID,
            'since_id' => $sinceID,
        ]);
    }
}
