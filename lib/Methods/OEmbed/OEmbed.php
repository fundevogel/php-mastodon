<?php

namespace Fundevogel\Mastodon\Methods\OEmbed;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class OEmbed
 *
 * For generating OEmbed previews
 */
class OEmbed extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'api/oembed';


    /**
     * OEmbed as JSON
     *
     * @param string $url
     * @param int $maxWidth
     * @param int $maxHeight
     *
     * @return array OEmbed metadata
     */
    public function get(string $url, int $maxWidth = 400, int $maxHeight = 400): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'url'       => $url,
            'maxwidth'  => $maxWidth,
            'maxheight' => $maxHeight,
        ]);
    }
}
