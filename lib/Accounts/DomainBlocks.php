<?php

namespace Fundevogel\Mastodon\Accounts;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class DomainBlocks
 *
 * View and update domain blocks
 */
class DomainBlocks extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'domain_blocks';


    /**
     * Fetch domain blocks
     *
     * View domains the user has blocked
     *
     * @param string $maxID Return results older than ID
     * @param string $sinceID Return results newer than ID
     * @param int $limit Maximum number of results
     *
     * @return array Array of strings
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


    /**
     * Block a domain
     *
     * Block a domain to:
     * - hide all public posts from it
     * - hide all notifications from it
     * - remove all followers from it
     * - prevent following new users from it (but does not remove existing follows)
     *
     * @param string $domain Domain to block
     *
     * @return array n/a
     */
    public function block(string $domain): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->post($endpoint, [
            'domain' => $domain,
        ]);
    }


    /**
     * Unblock a domain
     *
     * Remove a domain block, if it exists in the user's array of blocked domains
     *
     * @param string $domain Domain to unblock
     *
     * @return array n/a
     */
    public function unblock(string $domain): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->delete($endpoint, [
            'domain' => $domain,
        ]);
    }
}
