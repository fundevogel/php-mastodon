<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Notification
 *
 * Represents a notification of an event relevant to the user
 *
 * @see https://docs.joinmastodon.org/entities/notification
 */
class Notification extends Entity {
    /**
     * Required attributes
     */

    /**
     * The ID of the notification in the database
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * The type of event that resulted in the notification
     *
     * Enumerable oneOf:
     * `follow`         Someone followed you
     * `follow_request` Someone requested to follow you
     * `mention`        Someone mentioned you in their status
     * `reblog`         Someone boosted one of your statuses
     * `favourite`      Someone favourited one of your statuses
     * `poll`           A poll you have voted in or created has ended
     * `status`         Someone you enabled notifications for has posted a status
     *
     * @return string
     */
    public function type(): string
    {
        return $this->data['type'];
    }


    /**
     * The timestamp of the notification
     *
     * @return string ISO 8601 datetime
     */
    public function createdAt(): string
    {
        return $this->data['created_at'];
    }


    /**
     * The account that performed the action that generated the notification
     *
     * @return \Fundevogel\Mastodon\Entities\Account Account
     */
    public function account(): \Fundevogel\Mastodon\Entities\Account
    {
        return new \Fundevogel\Mastodon\Entities\Account($this->data['account']);
    }


    /**
     * Optional attributes
     */

    /**
     * Status that was the object of the notification, e.g. in mentions, reblogs, favourites, or polls
     *
     * @return null|\Fundevogel\Mastodon\Entities\Status
     */
    public function status()
    {
        # If not set ..
        if (!isset($this->data['status'])) {
            # .. status is not specified
            return null;
        }

        return new \Fundevogel\Mastodon\Entities\Status($this->data['status']);
    }
}
