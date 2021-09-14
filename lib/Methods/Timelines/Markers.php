<?php

namespace Fundevogel\Mastodon\Methods\Timelines;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Markers
 *
 * Save and restore your position in timelines
 */
class Markers extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'markers';


    /**
     * Get saved timeline position
     *
     * @param array $timeline Array of markers to fetch. String enum anyOf `home`, `notifications`. If not provided, an empty object will be returned
     *
     * @return array Marker
     */
    public function get(array $timeline): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'timeline' => $timeline,
        ]);
    }


    /**
     * Save position in timeline
     *
     * @param string $homeLastReadID ID of the last status read in the home timeline
     * @param string $notificationsLastReadID ID of the last notification read
     *
     * @return array Marker
     */
    public function save(string $homeLastReadID = '', string $notificationsLastReadID = ''): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->post($endpoint, [
            'home[last_read_id]' => $title,
            'notifications[last_read_id]' => $notificationsLastReadID,
        ]);
    }
}
