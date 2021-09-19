<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Announcement
 *
 * Represents an announcement set by an administrator
 *
 * @see https://docs.joinmastodon.org/entities/announcement
 */
class Announcement extends Entity {
    /**
     * Base attributes
     */

    /**
     * The announcement ID
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * The content of the announcement
     *
     * @return string
     */
    public function text(): string
    {
        return $this->data['text'];
    }


    /**
     * Whether the announcement is currently active
     *
     * @return bool
     */
    public function published(): bool
    {
        return $this->data['published'];
    }


    /**
     * Whether the announcement has a start/end time
     *
     * @return bool
     */
    public function allDay(): bool
    {
        return $this->data['all_day'];
    }


    /**
     * When the announcement was created
     *
     * @return string ISO 8601 datetime
     */
    public function createdAt(): string
    {
        return $this->data['created_at'];
    }


    /**
     * When the announcement was last updated
     *
     * @return string ISO 8601 datetime
     */
    public function updatedAt(): string
    {
        return $this->data['updated_at'];
    }


    /**
     * Whether the announcement has been read by the user
     *
     * @return bool
     */
    public function read(): bool
    {
        return $this->data['read'];
    }


    /**
     * Emoji reactions attached to the announcement
     *
     * @return array Array of AnnouncementReaction
     */
    public function reactions(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\AnnouncementReaction($data);
        }, $this->data['reactions']);
    }


    /**
     * Optional attributes
     */

    /**
     * When the future announcement was scheduled
     *
     * @return string ISO 8601 datetime
     */
    public function scheduledAt(): string
    {
        # If not set ..
        if (!isset($this->data['scheduled_at'])) {
            # .. scheduled date is not suspended
            return '';
        }

        return $this->data['scheduled_at'];
    }


    /**
     * When the future announcement will start
     *
     * @return string ISO 8601 datetime
     */
    public function startsAt(): string
    {
        # If not set ..
        if (!isset($this->data['starts_at'])) {
            # .. start date is not suspended
            return '';
        }

        return $this->data['starts_at'];
    }


    /**
     * When the future announcement will end
     *
     * @return string ISO 8601 datetime
     */
    public function endsAt(): string
    {
        # If not set ..
        if (!isset($this->data['ends_at'])) {
            # .. end date is not suspended
            return '';
        }

        return $this->data['ends_at'];
    }
}
