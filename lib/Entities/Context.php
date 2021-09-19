<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Context
 *
 * Represents the tree around a given status
 *
 * Used for reconstructing threads of statuses.
 *
 * @see https://docs.joinmastodon.org/entities/context
 */
class Context extends Entity {
    /**
     * Required attributes
     */

    /**
     * Parents in the thread
     *
     * @return array Array of Status
     */
    public function ancestors(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Status($data);
        }, $this->data['ancestors']);
    }


    /**
     * Parents in the thread
     *
     * @return array Array of Status
     */
    public function descendants(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Status($data);
        }, $this->data['descendants']);
    }
}
