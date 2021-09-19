<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class ListEntity
 *
 * Represents a list of some users that the authenticated user follows
 *
 * @see https://docs.joinmastodon.org/entities/list
 */
class ListEntity extends Entity {
    /**
     * Required attributes
     */

    /**
     * The internal database ID of the list
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * The user-defined title of the list
     *
     * @return string
     */
    public function title(): string
    {
        return $this->data['title'];
    }


    /**
     * The type of the attachment
     *
     * Enumerable oneOf:
     * `followed` Show replies to any followed user
     * `list`     Show replies to members of the list
     * `none`     Show replies to no one
     *
     * @return string
     */
    public function repliesPolicy(): string
    {
        return $this->data['replies_policy'];
    }
}
