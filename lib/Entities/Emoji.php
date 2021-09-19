<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Emoji
 *
 * Represents a custom emoji
 *
 * @see https://docs.joinmastodon.org/entities/emoji
 */
class Emoji extends Entity {
    /**
     * Required attributes
     */

    /**
     * The name of the custom emoji
     *
     * @return string
     */
    public function shortcode(): string
    {
        return $this->data['shortcode'];
    }


    /**
     * A link to the custom emoji
     *
     * @return string URL
     */
    public function url(): string
    {
        return $this->data['url'];
    }


    /**
     * A link to a static copy of the custom emoji
     *
     * @return string URL
     */
    public function staticUrl(): string
    {
        return $this->data['static_url'];
    }


    /**
     * Whether this Emoji should be visible in the picker or unlisted
     *
     * @return bool
     */
    public function visibleInPicker(): bool
    {
        return $this->data['visible_in_picker'];
    }


    /**
     * Optional attributes
     */

    /**
     * Used for sorting custom emoji in the picker
     *
     * @return string
     */
    public function category(): string
    {
        # If not set ..
        if (!isset($this->data['category'])) {
            # .. category is not specified
            return '';
        }

        return $this->data['category'];
    }
}
