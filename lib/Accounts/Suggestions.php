<?php

namespace Fundevogel\Mastodon\Accounts;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Suggestions
 *
 * Server-generated suggestions on who to follow, based on previous positive interactions
 */
class Suggestions extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'suggestions';


    /**
     * Gets follow suggestions
     *
     * @param int $limit
     * @return array
     */
    public function get(int $limit = 40): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'limit' => $limit,
        ]);
    }


    /**
     * Removes a suggestion
     *
     * @param string $id
     * @return array
     */
    public function remove(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->delete($endpoint);
    }
}
