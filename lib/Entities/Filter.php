<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Filter
 *
 * Represents a user-defined filter for determining which statuses should not be shown to the user
 *
 * @see https://docs.joinmastodon.org/entities/filter
 */
class Filter extends Entity {
    /**
     * Attributes
     */

    /**
     * The ID of the filter in the database
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * The text to be filtered
     *
     * @return string
     */
    public function phrase(): string
    {
        return $this->data['phrase'];
    }


    /**
     * The contexts in which the filter should be applied
     *
     * Enumerable anyOf:
     * `home`          home timeline and lists
     * `notifications` notifications timeline
     * `public`        public timelines
     * `thread`        expanded thread of a detailed status
     *
     * @return array
     */
    public function context(): array
    {
        return $this->data['context'];
    }


    /**
     * When the filter should no longer be applied
     *
     * @return null|string ISO 8601 datetime, or null if the filter does not expire
     */
    public function expiresAt()
    {
        return $this->data['expires_at'];
    }


    /**
     * Should matching entities in home and notifications be dropped by the server?
     *
     * @return bool
     */
    public function irreversible(): bool
    {
        return $this->data['irreversible'];
    }


    /**
     * Should the filter consider word boundaries?
     *
     * @see https://docs.joinmastodon.org/entities/filter/#implementation-notes
     *
     * @return bool
     */
    public function wholeWord(): bool
    {
        return $this->data['whole_word'];
    }
}
