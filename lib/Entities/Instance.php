<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Instance
 *
 * Represents the software instance of Mastodon running on this domain
 *
 * @see https://docs.joinmastodon.org/entities/instance
 */
class Instance extends Entity {
    /**
     * Required attributes
     */

    /**
     * The domain name of the instance
     *
     * @return string
     */
    public function uri(): string
    {
        return $this->data['uri'];
    }


    /**
     * The title of the website
     *
     * @return string
     */
    public function title(): string
    {
        return $this->data['title'];
    }


    /**
     * Admin-defined description of the Mastodon site
     *
     * @return string
     */
    public function description(): string
    {
        return $this->data['description'];
    }


    /**
     * A shorter description defined by the admin
     *
     * @return string
     */
    public function shortDescription(): string
    {
        return $this->data['short_description'];
    }


    /**
     * An email that may be contacted for any inquiries
     *
     * @return string
     */
    public function email(): string
    {
        return $this->data['email'];
    }


    /**
     * The version of Mastodon installed on the instance
     *
     * @return string
     */
    public function version(): string
    {
        return $this->data['version'];
    }


    /**
     * Primary langauges of the website and its staff
     *
     * @return string ISO 639-1 5 language codes
     */
    public function languages(): string
    {
        return $this->data['languages'];
    }


    /**
     * Whether registrations are enabled
     *
     * @return bool
     */
    public function registrations(): bool
    {
        return $this->data['registrations'];
    }


    /**
     * Whether registrations require moderator approval
     *
     * @return bool
     */
    public function approvalRequired(): bool
    {
        return $this->data['approval_required'];
    }


    /**
     * Whether invites are enabled
     *
     * @return bool
     */
    public function invitesEabled(): bool
    {
        return $this->data['invites_enabled'];
    }



    /**
     * URLs of interest for clients apps
     * - Websockets address for push streaming
     *
     * @return array
     */
    public function urls(): array
    {
        return $this->data['urls'];
    }


    /**
     * Statistics about how much information the instance contains
     *
     * - `user_count`   int Users registered on this instance
     * - `status_count` int Statuses authored by users on instance
     * - `domain_count` int Domains federated with this instance
     *
     * @return array
     */
    public function stats(): array
    {
        return $this->data['stats'];
    }


    /**
     * Optional attributes
     */

    /**
     * Banner image for the website
     *
     * @return null|string
     */
    public function thumbnail()
    {
        return $this->data['thumbnail'];
    }


    /**
     * A user that can be contacted, as an alternative to `email`
     *
     * @return null|\Fundevogel\Mastodon\Entities\Account Account
     */
    public function contactAccount()
    {
        # If not set ..
        if (!isset($this->data['contact_account'])) {
            # .. contact account is not specified
            return null;
        }

        return new \Fundevogel\Mastodon\Entities\Account($this->data['contact_account']);
    }
}
