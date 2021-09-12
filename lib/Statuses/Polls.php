<?php

namespace Fundevogel\Mastodon\Statuses;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Polls
 *
 * View and vote on polls attached to statuses
 */
class Polls extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'polls';


    /**
     * View a poll
     *
     * Creates an attachment to be used with a new status
     *
     * @param string $id ID of the poll in the database
     *
     * @return array Poll
     */
    public function get(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->get($endpoint);
    }


    /**
     * Vote on a poll
     *
     * @param string $id ID of the poll in the database
     * @param array $choices Array of own votes containing index for each option (starting from 0)
     *
     * @return array Poll
     */
    public function vote(string $id, array $choices): array
    {
        $endpoint = "{$this->endpoint}/{$id}/votes";

        return $this->api->post($endpoint);
    }
}
