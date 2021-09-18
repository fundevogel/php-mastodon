<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class FollowRequests
 *
 * View and manage follow requests
 *
 * @see https://docs.joinmastodon.org/methods/accounts/follow_requests
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

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Account($data);
        }, $this->api->get($endpoint, [
            'limit' => $limit,
        ]));
    }


    /**
     * Accept follow
     *
     * @param string $id ID of the account in the database
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function authorize(string $id): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/authorize";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint));
    }


    /**
     * Reject follow
     *
     * @param string $id ID of the account in the database
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function reject(string $id): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/reject";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint));
    }
}
