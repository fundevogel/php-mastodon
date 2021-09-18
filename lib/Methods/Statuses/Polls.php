<?php

namespace Fundevogel\Mastodon\Methods\Statuses;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Polls
 *
 * View and vote on polls attached to statuses
 *
 * @see https://docs.joinmastodon.org/methods/statuses/polls
 */
class Polls extends Method
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
     * @return \Fundevogel\Mastodon\Entities\Poll Poll
     */
    public function get(string $id): \Fundevogel\Mastodon\Entities\Poll
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return new \Fundevogel\Mastodon\Entities\Poll($this->api->get($endpoint));
    }


    /**
     * Vote on a poll
     *
     * @param string $id ID of the poll in the database
     * @param array $choices Array of own votes containing index for each option (starting from 0)
     *
     * @return \Fundevogel\Mastodon\Entities\Poll Poll
     */
    public function vote(string $id, array $choices): \Fundevogel\Mastodon\Entities\Poll
    {
        $endpoint = "{$this->endpoint}/{$id}/votes";

        return new \Fundevogel\Mastodon\Entities\Poll($this->api->post($endpoint));
    }
}
