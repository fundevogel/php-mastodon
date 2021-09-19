<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class AnnouncementReaction
 *
 * Represents an emoji reaction to an Announcement
 *
 * @see https://docs.joinmastodon.org/entities/announcementreaction
 */
class AnnouncementReaction extends Entity {
    /**
     * Base attributes
     */

    /**
     * The emoji used for the reaction
     *
     * Either a unicode emoji, or a custom emoji's shortcode.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->data['name'];
    }


    /**
     * The total number of users who have added this reaction
     *
     * @return int
     */
    public function count(): int
    {
        return $this->data['count'];
    }


    /**
     * Whether the authorized user has added this reaction to the announcement
     *
     * @return bool
     */
    public function me(): bool
    {
        return $this->data['me'];
    }


    /**
     * Custom emoji attributes
     */

    /**
     * A link to the custom emoji
     *
     * @return string URL
     */
    public function url(): string
    {
        return $this->data['url'];
    }


    /**
     * A link to a non-animated version of the custom emoji
     *
     * @return string URL
     */
    public function staticUrl(): string
    {
        return $this->data['static_url'];
    }
}
