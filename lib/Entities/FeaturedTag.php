<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class FeaturedTag
 *
 * Represents a hashtag that is featured on a profile
 *
 * @see https://docs.joinmastodon.org/entities/featuredtag
 */
class FeaturedTag extends Entity {
    /**
     * Attributes
     */

    /**
     * The internal ID of the featured tag in the database
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * The name of the hashtag being featured
     *
     * @return string
     */
    public function name(): string
    {
        return $this->data['name'];
    }


    /**
     * A link to all statuses by a user that contain this hashtag
     *
     * @return string URL
     */
    public function url(): string
    {
        return $this->data['url'];
    }


    /**
     * The number of authored statuses containing this hashtag
     *
     * @return int
     */
    public function statusesCount(): int
    {
        return $this->data['statuses_count'];
    }


    /**
     * The timestamp of the last authored status containing this hashtag
     *
     * @return string ISO 8601 datetime
     */
    public function lastStatusAt(): string
    {
        return $this->data['last_status_at'];
    }
}
