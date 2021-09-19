<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Marker
 *
 * Represents the last read position within a user's timelines
 *
 * @see https://docs.joinmastodon.org/entities/marker
 */
class Marker extends Entity {
    /**
     * Base attributes
     */

    /**
     * Information about the user's position in the home timeline
     *
     * @return array
     */
    public function home(): array
    {
        return $this->data['home'];
    }


    /**
     * Information about the user's position in their notifications
     *
     * @return array
     */
    public function notifications(): array
    {
        return $this->data['notifications'];
    }


    /**
     * Nested attributes
     */

    /**
     * The ID of the most recently viewed entity
     *
     * @return string
     */
    public function lastReadID(): string
    {
        return $this->data['last_read_id'];
    }


    /**
     * The timestamp of when the marker was set
     *
     * @return string ISO 8601 datetime
     */
    public function updatedAt(): string
    {
        return $this->data['updated_at'];
    }


    /**
     * Used for locking to prevent write conflicts
     *
     * @return string
     */
    public function version(): string
    {
        return $this->data['version'];
    }
}
