<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Preferences
 *
 * Represents a user's preferences
 *
 * @see https://docs.joinmastodon.org/entities/preferences
 */
class Preferences extends Entity {
    /**
     *
     */

    /**
     * Default visibility for new posts
     *
     * Enumerable oneOf:
     * `public`   Public post
     * `unlisted` Unlisted post
     * `private`  Followers-only post
     * `direct`   Direct post
     *
     * @return string
     */
    public function postingDefaultVisibility(): string
    {
        return $this->data['posting:default:visibility'];
    }


    /**
     * Default language for new posts
     *
     * @return null|string ISO 639-1 language two-letter code, or null
     */
    public function postingDefaultLanguage()
    {
        return $this->data['posting:default:language'];
    }


    /**
     * Whether media attachments should be automatically displayed or blurred/hidden
     *
     * Enumerable oneOf:
     * `default`  Hide media marked as sensitive
     * `show_all` Always show all media by default, regardless of sensitivity
     * `hide_all` Always hide all media by default, regardless of sensitivity
     *
     * @return string
     */
    public function readingExpandMedia(): string
    {
        return $this->data['reading:expand:media'];
    }


    /**
     * Whether CWs should be expanded by default
     *
     * @return bool
     */
    public function readingExpandSpoilers(): bool
    {
        return $this->data['reading:expand:spoilers'];
    }
}
