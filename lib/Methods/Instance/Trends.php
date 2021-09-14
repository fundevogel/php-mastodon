<?php

namespace Fundevogel\Mastodon\Methods\Instance;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Trends
 *
 * View hashtags that are currently being used more frequently than usual
 */
class Trends extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'trends';


    /**
     * Trending tags
     *
     * Tags that are being used more frequently within the past week
     *
     * @param int $limit Maximum number of results to return
     *
     * @return array Array of Tag with History
     */
    public function get(int $limit = 10): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'limit' => $limit,
        ]);
    }
}
