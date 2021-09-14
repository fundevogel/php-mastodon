<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class FollowRequests
 *
 * View and manage follow requests
 */
class FollowRequests extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'follow_requests';


    /**
     * Pending Follows
     *
     * @param int $limit Maximum number of results to return
     *
     * @return array Array of Account
     */
    public function get(int $limit = 40): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'limit'    => $limit,
        ]);
    }


    /**
     * Accept follow
     *
     * @param string $id ID of the account in the database
     *
     * @return array Relationship
     */
    public function authorize(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/authorize";

        return $this->api->post($endpoint);
    }


    /**
     * Reject follow
     *
     * @param string $id ID of the account in the database
     *
     * @return array Relationship
     */
    public function reject(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/reject";

        return $this->api->post($endpoint);
    }
}
