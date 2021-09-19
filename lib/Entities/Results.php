<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Results
 *
 * Represents the results of a search
 *
 * @see https://docs.joinmastodon.org/entities/results
 */
class Results extends Entity {
    /**
     * Required attributes
     */

    /**
     * Accounts which match the given query
     *
     * @return array Array of Account
     */
    public function accounts(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Account($data);
        }, $this->data['accounts']);
    }


    /**
     * Statuses which match the given query
     *
     * @return array Array of Status
     */
    public function statuses(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Status($data);
        }, $this->data['statuses']);
    }


    /**
     * Hashtags which match the given query
     *
     * @return array Array of Tag
     */
    public function hashtags(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Tag($data);
        }, $this->data['statuses']);
    }
}
