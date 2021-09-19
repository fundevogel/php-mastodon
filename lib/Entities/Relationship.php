<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Relationship
 *
 * Represents the relationship between accounts, such as following / blocking / muting / etc
 *
 * @see https://docs.joinmastodon.org/entities/relationship
 */
class Relationship extends Entity {
    /**
     * Required attributes
     */

    /**
     * The account ID
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * Are you following this user?
     *
     * @return bool
     */
    public function following(): bool
    {
        return $this->data['following'];
    }


    /**
     * Do you have a pending follow request for this user?
     *
     * @return bool
     */
    public function requested(): bool
    {
        return $this->data['requested'];
    }


    /**
     * Are you featuring this user on your profile?
     *
     * @return bool
     */
    public function endorsed(): bool
    {
        return $this->data['endorsed'];
    }


    /**
     * Are you followed by this user?
     *
     * @return bool
     */
    public function followedBy(): bool
    {
        return $this->data['followed_by'];
    }


    /**
     * Are you muting this user?
     *
     * @return bool
     */
    public function muting(): bool
    {
        return $this->data['muting'];
    }


    /**
     * Are you muting notifications from this user?
     *
     * @return bool
     */
    public function mutingNotifications(): bool
    {
        return $this->data['muting_notifications'];
    }


    /**
     * Are you receiving this user's boosts in your home timeline?
     *
     * @return bool
     */
    public function showingReblogs(): bool
    {
        return $this->data['showing_reblogs'];
    }


    /**
     * Have you enabled notifications for this user?
     *
     * @return bool
     */
    public function notifying(): bool
    {
        return $this->data['notifying'];
    }


    /**
     * Are you blocking this user?
     *
     * @return bool
     */
    public function blocking(): bool
    {
        return $this->data['blocking'];
    }


    /**
     * Are you blocking this user's domain?
     *
     * @return bool
     */
    public function domainBlocking(): bool
    {
        return $this->data['domain_blocking'];
    }


    /**
     * Is this user blocking you?
     *
     * @return bool
     */
    public function blockedBy(): bool
    {
        return $this->data['blocked_by'];
    }


    /**
     * This user's profile bio
     *
     * @return string
     */
    public function note(): string
    {
        return $this->data['note'];
    }
}
