<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Source
 *
 * Represents display or publishing preferences of user's own account
 *
 * Returned as an additional entity when verifying and updated credentials,
 * as an attribute of Account.
 *
 * @see https://docs.joinmastodon.org/entities/source
 */
class Source extends Entity {
    /**
     * Base attributes
     */

    /**
     * Profile bio
     *
     * @return string
     */
    public function note(): string
    {
        return $this->data['note'];
    }


    /**
     * Metadata about the account
     *
     * @return array Array of Field
     */
    public function fields(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Field($data);
        }, $this->data['fields']);
    }


    /**
     * Nullable attributes
     */

    /**
     * The default post privacy to be used for new statuses
     *
     * Enumerable oneOf:
     * `public`   Public post
     * `unlisted` Unlisted post
     * `private`  Followers-only post
     * `direct`   Direct post
     *
     * @return null|string
     */
    public function privacy()
    {
        return $this->data['privacy'];
    }


    /**
     * Whether new statuses should be marked sensitive by default
     *
     * @return null|bool
     */
    public function sensitive()
    {
        return $this->data['sensitive'];
    }


    /**
     * The default posting language for new statuses
     *
     * @return null|string ISO 639-1 language two-letter code
     */
    public function language()
    {
        return $this->data['language'];
    }


    /**
     * The number of pending follow requests
     *
     * @return null|int
     */
    public function followRequestsCount()
    {
        return $this->data['follow_requests_count'];
    }
}
