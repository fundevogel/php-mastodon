<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class History
 *
 * Represents daily usage history of a hashtag
 *
 * @see https://docs.joinmastodon.org/entities/history
 */
class History extends Entity {
    /**
     * Required attributes
     */

    /**
     * UNIX timestamp on midnight of the given day
     *
     * @return string UNIX timestamp
     */
    public function day(): string
    {
        return $this->data['day'];
    }


    /**
     * The counted usage of the tag within that day
     *
     * @return string UNIX timestamp
     */
    public function uses(): string
    {
        return $this->data['uses'];
    }


    /**
     * The total of accounts using the tag within that day.
     *
     * @return string
     */
    public function accounts(): string
    {
        return $this->data['accounts'];
    }
}
