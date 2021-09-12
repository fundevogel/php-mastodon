<?php

namespace Fundevogel\Mastodon\Accounts;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class FeaturedTags
 *
 * Feature tags that you use frequently
 */
class FeaturedTags extends ApiMethod
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

        return $this->api->get($endpoint);
    }


    /**
     * Feature a tag
     *
     * @param string $name The hashtag to be featured
     *
     * @return array FeaturedTag
     */
    public function feature(string $name): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->post($endpoint, [
            'name' => $name,
        ]);
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

        return $this->api->get($endpoint);
    }
}
