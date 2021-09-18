<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class FeaturedTags
 *
 * Feature tags that you use frequently
 */
class FeaturedTags extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'featured_tags';


    /**
     * View your featured tags
     *
     * @return array Array of FeaturedTag
     */
    public function get(): array
    {
        $endpoint = "{$this->endpoint}";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\FeaturedTag($data);
        }, $this->api->get($endpoint));
    }


    /**
     * Feature a tag
     *
     * @param string $name The hashtag to be featured
     *
     * @return \Fundevogel\Mastodon\Entities\FeaturedTag FeaturedTag
     */
    public function feature(string $name): \Fundevogel\Mastodon\Entities\FeaturedTag
    {
        $endpoint = "{$this->endpoint}";

        return new \Fundevogel\Mastodon\Entities\FeaturedTag($this->api->post($endpoint, [
            'name' => $name,
        ]));
    }


    /**
     * Unfeature a tag
     *
     * @param string $id The ID of the FeaturedTag to be unfeatured
     *
     * @return array empty object
     */
    public function unfeature(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->delete($endpoint);
    }


    /**
     * Suggested tags to feature
     *
     * Shows your 10 most-used tags, with usage history for the past week
     *
     * @return array Array of Tag with History
     */
    public function suggestions(): array
    {
        $endpoint = "{$this->endpoint}/suggestions";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Tag($data);
        }, $this->api->get($endpoint));
    }
}
