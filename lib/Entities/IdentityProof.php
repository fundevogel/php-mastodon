<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class IdentityProof
 *
 * Represents a proof from an external identity provider
 *
 * @see https://docs.joinmastodon.org/entities/identityproof
 */
class IdentityProof extends Entity {
    /**
     * Attributes
     */

    /**
     * The name of the identity provider
     *
     * @return string
     */
    public function provider(): string
    {
        return $this->data['provider'];
    }


    /**
     * The account owner's username on the identity provider's service
     *
     * @return string
     */
    public function providerUsername(): string
    {
        return $this->data['provider_username'];
    }


    /**
     * The account owner's profile URL on the identity provider
     *
     * @return string URL
     */
    public function profileUrl(): string
    {
        return $this->data['profile_url'];
    }


    /**
     * A link to a statement of identity proof, hosted by the identity provider
     *
     * @return string URL
     */
    public function proofUrl(): string
    {
        return $this->data['proof_url'];
    }


    /**
     * When the identity proof was last updated
     *
     * @return string ISO 8601 datetime
     */
    public function updatedAt(): string
    {
        return $this->data['updated_at'];
    }
}
