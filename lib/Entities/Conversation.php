<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Conversation
 *
 * Represents a conversation with "direct message" visibility
 *
 * @see https://docs.joinmastodon.org/entities/conversation
 */
class Conversation extends Entity {
    /**
     * Required attributes
     */

    /**
     * Local database ID of the conversation
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * Participants in the conversation
     *
     * @return array Array of Account
     */
    public function accounts(): array
    {
        return array_map(function () {
            return new \Fundevogel\Mastodon\Entities\Account($data);
        }, $this->data['accounts']);
    }


    /**
     * Is the conversation currently marked as unread?
     *
     * @return bool
     */
    public function unread(): bool
    {
        return $this->data['unread'];
    }


    /**
     * Optional attributes
     */

    /**
     * Is the conversation currently marked as unread?
     *
     * @return null|\Fundevogel\Mastodon\Entities\Status
     */
    public function lastStatus()
    {
        # If not set ..
        if (!isset($this->data['last_status'])) {
            # .. website is not specified
            return null;
        }

        return new \Fundevogel\Mastodon\Entities\Status($this->data['last_status']);
    }
}
