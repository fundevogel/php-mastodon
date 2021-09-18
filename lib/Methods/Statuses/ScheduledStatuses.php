<?php

namespace Fundevogel\Mastodon\Methods\Statuses;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class ScheduledStatuses
 *
 * Schedule statuses for your instance to publish later
 *
 * @see https://docs.joinmastodon.org/methods/statuses/scheduled_statuses
 */
class ScheduledStatuses extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'scheduled_statuses';


    /**
     * View scheduled statuses
     *
     * @param int $limit Max number of results to return
     * @param string $maxID Return results older than ID
     * @param string $sinceID Return results newer than ID
     * @param string $minID Return results immediately newer than ID
     *
     * @return array Array of ScheduledStatus
     */
    public function all(int $limit = 20, string $maxID = '', string $sinceID = '', string $minID = ''): array
    {
        $endpoint = "{$this->endpoint}";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\ScheduledStatus($data);
        }, $this->api->get($endpoint, [
            'limit'    => $limit,
            'max_id'   => $maxID,
            'since_id' => $sinceID,
            'min_id'   => $minID,
        ]));
    }


    /**
     * View a single scheduled status
     *
     * @param string $id ID of the scheduled status in the database
     *
     * @return \Fundevogel\Mastodon\Entities\ScheduledStatus ScheduledStatus
     */
    public function get(string $id): \Fundevogel\Mastodon\Entities\ScheduledStatus
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return new \Fundevogel\Mastodon\Entities\ScheduledStatus($this->api->get($endpoint));
    }


    /**
     * Schedule a status
     *
     * @param string $id ID of the Status to be scheduled
     * @param string $scheduledAt ISO 8601 Datetime at which the status will be published. Must be at least 5 minutes into the future
     *
     * @return \Fundevogel\Mastodon\Entities\ScheduledStatus ScheduledStatus
     */
    public function schedule(string $id, string $scheduledAt = ''): \Fundevogel\Mastodon\Entities\ScheduledStatus
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return new \Fundevogel\Mastodon\Entities\ScheduledStatus($this->api->put($endpoint, [
            'scheduled_at' => $scheduledAt,
        ]));
    }


    /**
     * Cancel a scheduled status
     *
     * @param string $id ID of the scheduled status in the database
     *
     * @return array empty object
     */
    public function cancel(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->delete($endpoint);
    }
}
