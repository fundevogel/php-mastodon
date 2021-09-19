<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Field
 *
 * Represents a profile field as a name-value pair with optional verification
 *
 * @see https://docs.joinmastodon.org/entities/field
 */
class Field extends Entity {
    /**
     * Required attributes
     */

    /**
     * The key of a given field's key-value pair
     *
     * @return string
     */
    public function name(): string
    {
        return $this->data['name'];
    }


    /**
     * The value associated with the `name` key
     *
     * @return string HTML
     */
    public function value(): string
    {
        return $this->data['value'];
    }


    /**
     * Optional attributes
     */

    /**
     * Timestamp of when the server verified a URL value for a rel="me” link
     *
     * @return null|string ISO 8601 datetime if `value` is a verified URL, otherwise `null`
     */
    public function verifiedAt()
    {
        return $this->data['verified_at'];
    }
}
