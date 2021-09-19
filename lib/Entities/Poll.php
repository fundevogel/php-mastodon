<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Poll
 *
 * Represents a poll attached to a status
 *
 * @see https://docs.joinmastodon.org/entities/poll
 */
class Poll extends Entity {
    /**
     * Attributes
     */

    /**
     * The ID of the poll in the database
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * The ID of the poll in the database
     *
     * @return null|string ISO 8601 datetime, or null if the poll does not end
     */
    public function expiresAt()
    {
        return $this->data['expires_at'];
    }


    /**
     * Is the poll currently expired?
     *
     * @return bool
     */
    public function expired(): bool
    {
        return $this->data['expired'];
    }


    /**
     * Does the poll allow multiple-choice answers?
     *
     * @return bool
     */
    public function multiple(): bool
    {
        return $this->data['multiple'];
    }


    /**
     * How many votes have been received
     *
     * @return int
     */
    public function votesCount(): int
    {
        return $this->data['votes_count'];
    }


    /**
     * When called with a user token, has the authorized user voted?
     *
     * @return null|bool null if no current user
     */
    public function voted()
    {
        return $this->data['voted'];
    }


    /**
     * When called with a user token, which options has the authorized user chosen?
     *
     * Contains an array of index values for `options`.
     *
     * @return null|array null if no current user
     */
    public function ownVotes()
    {
        return $this->data['own_votes'];
    }


    /**
     * Possible answers for the poll
     *
     * - `title`       string   The text value of the poll option
     * - `votes_count` null|int The number of received votes for this option, null if results are not published yet
     *
     * @return array
     */
    public function options()
    {
        return $this->data['options'];
    }


    /**
     * Custom emoji to be used for rendering poll options
     *
     * @return array Array of Emoji
     */
    public function emojis()
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Emoji($data);
        }, $this->data['emojis']);
    }
}
