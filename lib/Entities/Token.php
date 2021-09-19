<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Token
 *
 * Represents an OAuth token used for authenticating with the API and performing actions
 *
 * @see https://docs.joinmastodon.org/entities/token
 */
class Token extends Entity {
    /**
     * Attributes
     */

    /**
     * An OAuth token to be used for authorization
     *
     * @return string
     */
    public function accessToken(): string
    {
        return $this->data['access_token'];
    }


    /**
     * The OAuth token type
     *
     * Mastodon uses `Bearer` tokens.
     *
     * @return string
     */
    public function tokenType(): string
    {
        return $this->data['token_type'];
    }


    /**
     * The OAuth scopes granted by this token, space-separated
     *
     * @return string
     */
    public function scope(): string
    {
        return $this->data['scope'];
    }


    /**
     * When the token was generated
     *
     * @return int Number (UNIX Timestamp
     */
    public function createdAt(): int
    {
        return $this->data['created_at'];
    }


    /**
     * Custom methods
     */

    /**
     * Check for access token
     *
     * @return bool Whether access token is present
     */
    public function hasAccessToken(): bool
    {
        return isset($this->data['access_token']);
    }
}
