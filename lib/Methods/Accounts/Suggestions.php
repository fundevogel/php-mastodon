<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Suggestions
 *
 * Server-generated suggestions on who to follow, based on previous positive interactions
 *
 * @see https://docs.joinmastodon.org/methods/accounts/suggestions
 */
class Suggestions extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'suggestions';


    /**
     * Follow suggestions
     *
     * Accounts the user has had past positive interactions with, but is not yet following
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
     * Remove a suggestion
     *
     * Remove an account from follow suggestions
     *
     * @param string $id ID of the account in the database to be removed from suggestions
     *
     * @return array n/a
     */
    public function remove(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->delete($endpoint);
    }
}
