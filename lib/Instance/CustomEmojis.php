<?php

namespace Fundevogel\Mastodon\Instance;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class CustomEmojis
 *
 * Each site can define and upload its own custom emoji to be attached to profiles or statuses
 */
class CustomEmojis extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'custom_emojis';


    /**
     * Custom emoji
     *
     * Returns custom emojis that are available on the server
     *
     * @return array Array of Emoji
     */
    public function get(): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint);
    }
}
