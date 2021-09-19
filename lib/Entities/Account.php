<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Account
 *
 * Represents a user of Mastodon and their associated profile
 *
 * @see https://docs.joinmastodon.org/entities/account
 */
class Account extends Entity {
    /**
     * Base attributes
     */

    /**
     * The account ID `header`
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * The username of the account, not including domain
     *
     * @return string
     */
    public function username(): string
    {
        return $this->data['username'];
    }


    /**
     * The Webfinger account URI
     *
     * Equal to `username` for local users, or `username@domain` for remote users.
     *
     * @return string
     */
    public function acct(): string
    {
        return $this->data['acct'];
    }


    /**
     * The location of the user's profile page
     *
     * @return string HTTPS URL
     */
    public function url(): string
    {
        return $this->data['url'];
    }


    /**
     * Display attributes
     */

    /**
     * The profile's display name
     *
     * @return string HTTPS URL
     */
    public function displayName(): string
    {
        return $this->data['display_name'];
    }


    /**
     * The profile's bio / description
     *
     * @return string HTML
     */
    public function note(): string
    {
        return $this->data['note'];
    }


    /**
     * An image icon that is shown next to statuses and in the profile
     *
     * @return string URL
     */
    public function avatar(): string
    {
        return $this->data['avatar'];
    }


    /**
     * A static version of the avatar
     *
     * Equal to `avatar` if its value is a static image;
     * different if `avatar` is an animated GIF.
     *
     * @return string URL
     */
    public function avatarStatic(): string
    {
        return $this->data['avatar_static'];
    }


    /**
     * An image banner that is shown above the profile and in profile cards
     *
     * @return string URL
     */
    public function header(): string
    {
        return $this->data['header'];
    }


    /**
     * A static version of the header
     *
     * Equal to `header` if its value is a static image;
     * different if `header` is an animated GIF.
     *
     * @return string URL
     */
    public function headerStatic(): string
    {
        return $this->data['header_static'];
    }


    /**
     * Whether the account manually approves follow requests
     *
     * @return bool
     */
    public function locked(): bool
    {
        return $this->data['locked'];
    }


    /**
     * Custom emoji entities to be used when rendering the profile
     *
     * If none, an empty array will be returned.
     *
     * @return array Array of Emoji
     */
    public function emojis(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Emoji($data);
        }, $this->data['emojis']);
    }


    /**
     * Whether the account has opted into discovery features such as the profile directory
     *
     * @return bool
     */
    public function discoverable(): bool
    {
        return $this->data['discoverable'];
    }


    /**
     * Statistical attributes
     */

    /**
     * When the account was created
     *
     * @return string ISO 8601 datetime
     */
    public function createdAt(): string
    {
        return $this->data['created_at'];
    }


    /**
     * When the most recent status was posted
     *
     * @return string ISO 8601 datetime
     */
    public function lastStatusAt(): string
    {
        return $this->data['last_status_at'];
    }


    /**
     * How many statuses are attached to this account
     *
     * @return int
     */
    public function statusesCount(): int
    {
        return $this->data['statuses_count'];
    }


    /**
     * The reported followers of this profile
     *
     * @return int
     */
    public function followersCount(): int
    {
        return $this->data['followers_count'];
    }


    /**
     * The reported follows of this profile
     *
     * @return int
     */
    public function followingCount(): int
    {
        return $this->data['following_count'];
    }


    /**
     * Optional attributes
     */

    /**
     * Indicates that the profile is currently inactive and that its user has moved to a new account
     *
     * @return \Fundevogel\Mastodon\Entities\Account Account
     */
    public function moved(): \Fundevogel\Mastodon\Entities\Account
    {
        return new \Fundevogel\Mastodon\Entities\Account($this->data['moved']);
    }


    /**
     * Additional metadata attached to a profile as name-value pairs
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
     * Indicates that the account may perform automated actions, may not be monitored, or identifies as a robot
     *
     * @return bool
     */
    public function bot(): bool
    {
        return $this->data['bot'];
    }


    /**
     * An extra entity to be used with API methods to verify credentials and update credentials
     *
     * @return \Fundevogel\Mastodon\Entities\Source Source
     */
    public function source(): \Fundevogel\Mastodon\Entities\Source
    {
        return new \Fundevogel\Mastodon\Entities\Source($this->data['source']);
    }


    /**
     * An extra entity returned when an account is suspended
     *
     * @return bool
     */
    public function suspended(): bool
    {
        # If not set ..
        if (!isset($this->data['suspended'])) {
            # .. account is not suspended
            return false;
        }

        return $this->data['suspended'];
    }


    /**
     * When a timed mute will expire, if applicable
     *
     * @return string ISO 8601 datetime
     */
    public function muteExpiresAt(): string
    {
        return $this->data['mute_expires_at'];
    }


    /**
     * Custom methods
     */

    /**
     * Check for `moved`
     *
     * @return bool
     */
    public function hasMoved(): bool
    {
        return isset($this->data['moved']);
    }


    /**
     * Check for `fields`
     *
     * @return bool
     */
    public function hasFields(): bool
    {
        return isset($this->data['moved']);
    }


    /**
     * Check for `fields`
     *
     * @return bool
     */
    public function hasMuteExpiresAt(): bool
    {
        return isset($this->data['mute_expires_at']);
    }
}
