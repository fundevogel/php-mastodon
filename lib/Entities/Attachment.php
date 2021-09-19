<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Attachment
 *
 * Represents a file or media attachment that can be added to a status
 *
 * @see https://docs.joinmastodon.org/entities/attachment
 */
class Attachment extends Entity {
    /**
     * Required attributes
     */

    /**
     * The ID of the attachment in the database
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * The type of the attachment
     *
     * Enumerable oneOf:
     * `unknown` unsupported or unrecognized file type
     * `image`   Static image
     * `gifv`    Looping, soundless animation
     * `video`   Video clip
     * `audio`   Audio track
     *
     * @return string
     */
    public function type(): string
    {
        return $this->data['type'];
    }


    /**
     * The location of the original full-size attachment
     *
     * @return string URL
     */
    public function url(): string
    {
        return $this->data['url'];
    }


    /**
     * The location of a scaled-down preview of the attachment
     *
     * @return string URL
     */
    public function previewUrl(): string
    {
        return $this->data['preview_url'];
    }


    /**
     * Optional attributes
     */

    /**
     * The location of the full-size original attachment on the remote website
     *
     * @return null|string `null` if the attachment is local
     */
    public function remoteUrl()
    {
        return $this->data['remote_url'];
    }


    /**
     * Metadata returned by Paperclip
     *
     * May contain subtrees `small` and `original`, as well as various other top-level properties
     *
     * More importantly, there may be another top-level focus
     * Hash object as of 2.3.0, with coordinates can be used
     * for smart thumbnail cropping.
     *
     * @see https://docs.joinmastodon.org/methods/statuses/media/#focal-points
     *
     * @return array
     */
    public function meta(): array
    {
        return $this->data['meta'];
    }


    /**
     * Alternate text that describes what is in the media attachment, to be used for the visually impaired or when media attachments do not load
     *
     * @return string
     */
    public function description(): string
    {
        # If not set ..
        if (!isset($this->data['description'])) {
            # .. description is not specified
            return '';
        }

        return $this->data['description'];
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


    /**
     * Deprecated attributes
     */

    /**
     * A shorter URL for the attachment
     *
     * Deprecated in 3.5.0
     *
     * @return string URL
     */
    public function textUrl(): string
    {
        # If not set ..
        if (!isset($this->data['text_url'])) {
            # .. text URL is not specified
            return '';
        }

        return $this->data['text_url'];
    }
}
