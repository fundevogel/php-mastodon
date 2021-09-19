<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Application
 *
 * Represents an application that interfaces with the REST API to access accounts or post statuses
 *
 * @see https://docs.joinmastodon.org/entities/application
 */
class Application extends Entity {
    /**
     * Required attributes
     */

    /**
     * The name of your application
     *
     * @return string
     */
    public function name(): string
    {
        return $this->data['name'];
    }


    /**
     * Optional attributes
     */

    /**
     * The name of your application
     *
     * @return string
     */
    public function website()
    {
        # If not set ..
        if (!isset($this->data['website'])) {
            # .. website is not specified
            return '';
        }

        return $this->data['website'];
    }


    /**
     * Used for Push Streaming API
     *
     * @return null|string
     */
    public function vapidKey()
    {
        # If not set ..
        if (!isset($this->data['vapid_key'])) {
            # .. streaming API key is not specified
            return '';
        }

        return $this->data['vapid_key'];
    }


    /**
     * Client attributes
     */

    /**
     * Client ID key, to be used for obtaining OAuth tokens
     *
     * @return string
     */
    public function clientID(): string
    {
        if (!isset($this->data['client_id'])) {
            return '';
        }

        return $this->data['client_id'];
    }


    /**
     * Client secret key, to be used for obtaining OAuth tokens
     *
     * @return string
     */
    public function clientSecret(): string
    {
        if (!isset($this->data['client_secret'])) {
            return '';
        }

        return $this->data['client_secret'];
    }
}
