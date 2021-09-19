<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Card
 *
 * Represents a rich preview card that is generated using OpenGraph tags from a URL
 *
 * @see https://docs.joinmastodon.org/entities/card
 */
class Card extends Entity {
    /**
     * Base attributes
     */

    /**
     * Location of linked resource
     *
     * @return string URL
     */
    public function url(): string
    {
        return $this->data['url'];
    }


    /**
     * Title of linked resource
     *
     * @return string
     */
    public function title(): string
    {
        return $this->data['title'];
    }


    /**
     * Description of preview
     *
     * @return string
     */
    public function description(): string
    {
        return $this->data['description'];
    }


    /**
     * The type of the preview card
     *
     * Enumerable oneOf:
     * `link`  Link OEmbed
     * `photo` Photo OEmbed
     * `video` Video OEmbed
     * `rich`  iframe OEmbed. Not currently accepted, so won't show up in practice
     *
     * @return string
     */
    public function type(): string
    {
        return $this->data['type'];
    }


    /**
     * Optional attributes
     */

    /**
     * Description of preview
     *
     * @return string
     */
    public function authorName(): string
    {
        # If not set ..
        if (!isset($this->data['author_name'])) {
            # .. author name is not specified
            return '';
        }

        return $this->data['author_name'];
    }


    /**
     * A link to the author of the original resource
     *
     * @return string URL
     */
    public function authorUrl(): string
    {
        # If not set ..
        if (!isset($this->data['author_url'])) {
            # .. author name is not specified
            return '';
        }

        return $this->data['author_url'];
    }


    /**
     * The provider of the original resource
     *
     * @return string
     */
    public function providerName(): string
    {
        # If not set ..
        if (!isset($this->data['provider_name'])) {
            # .. provider name is not specified
            return '';
        }

        return $this->data['provider_name'];
    }


    /**
     * A link to the provider of the original resource
     *
     * @return string URL
     */
    public function providerUrl(): string
    {
        # If not set ..
        if (!isset($this->data['provider_url'])) {
            # .. provider name is not specified
            return '';
        }

        return $this->data['provider_url'];
    }


    /**
     * HTML to be used for generating the preview card
     *
     * @return string HTML
     */
    public function html(): string
    {
        # If not set ..
        if (!isset($this->data['html'])) {
            # .. preview card HTML is not specified
            return '';
        }

        return $this->data['html'];
    }


    /**
     * Width of preview, in pixels
     *
     * @return int
     */
    public function width(): int
    {
        # If not set ..
        if (!isset($this->data['width'])) {
            # .. width is not specified
            return 0;
        }

        return $this->data['width'];
    }


    /**
     * Height of preview, in pixels
     *
     * @return int
     */
    public function height(): int
    {
        # If not set ..
        if (!isset($this->data['height'])) {
            # .. height is not specified
            return 0;
        }

        return $this->data['height'];
    }


    /**
     * Preview thumbnail
     *
     * @return string URL
     */
    public function image(): string
    {
        # If not set ..
        if (!isset($this->data['image'])) {
            # .. image is not specified
            return '';
        }

        return $this->data['image'];
    }


    /**
     * Used for photo embeds, instead of custom `html`
     *
     * @return string URL
     */
    public function embedUrl(): string
    {
        # If not set ..
        if (!isset($this->data['embed_url'])) {
            # .. embed URL is not specified
            return '';
        }

        return $this->data['embed_url'];
    }


    /**
     * A hash computed by the BlurHash algorithm, for generating colorful preview thumbnails when media has not been downloaded yet
     *
     * @see https://github.com/woltapp/blurhash
     *
     * @return string
     */
    public function blurhash(): string
    {
        # If not set ..
        if (!isset($this->data['blurhash'])) {
            # .. blur hash is not specified
            return '';
        }

        return $this->data['blurhash'];
    }
}
