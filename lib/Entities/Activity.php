<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Activity
 *
 * Represents a weekly bucket of instance activity
 *
 * @see https://docs.joinmastodon.org/entities/activity
 */
class Activity extends Entity {
    /**
     * Attributes
     */

    /**
     * Midnight at the first day of the week
     *
     * @return string UNIX timestamp
     */
    public function week(): string
    {
        return $this->data['week'];
    }


    /**
     * Statuses created since the week began
     *
     * @return string
     */
    public function statuses(): string
    {
        return $this->data['statuses'];
    }


    /**
     * User logins since the week began
     *
     * @return string
     */
    public function logins(): string
    {
        return $this->data['logins'];
    }


    /**
     * User registrations since the week began
     *
     * @return string
     */
    public function registrations(): string
    {
        return $this->data['registrations'];
    }
}
