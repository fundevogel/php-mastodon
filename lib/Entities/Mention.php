<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Mention
 *
 * Represents a mention of a user within the content of a status
 *
 * @see https://docs.joinmastodon.org/entities/mention
 */
class Mention extends Entity {
    /**
     * Required attributes
     */

    /**
     * The account ID of the mentioned user
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * The username of the mentioned user
     *
     * @return string
     */
    public function username(): string
    {
        return $this->data['username'];
    }


    /**
     * The Webfinger account URI
     *
     * Equal to `username` for local users, or `username@domain` for remote users.
     *
     * @return string
     */
    public function acct(): string
    {
        return $this->data['acct'];
    }


    /**
     * The location of the mentioned user's profile
     *
     * @return string URL
     */
    public function url(): string
    {
        return $this->data['url'];
    }
}
