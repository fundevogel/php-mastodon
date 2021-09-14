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
     * Gets muted accounts
     *
     * @param int $limit
     * @param string $maxID
     * @param string $sinceID
     * @return array
     */
    public function get(int $limit = 40, string $maxID = '', string $sinceID = ''): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'limit'    => $limit,
            'max_id'   => $maxID,
            'since_id' => $sinceID,
        ]);
    }
}
