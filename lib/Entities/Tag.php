<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Tag
 *
 * Represents a hashtag used within the content of a status
 *
 * @see https://docs.joinmastodon.org/entities/tag
 */
class Tag extends Entity {
    /**
     * Base attributes
     */

    /**
     * The value of the hashtag after the # sign
     *
     * @return string
     */
    public function name(): string
    {
        return $this->data['name'];
    }


    /**
     * A link to the hashtag on the instance
     *
     * @return string URL
     */
    public function url(): string
    {
        return $this->data['url'];
    }


    /**
     * Optional attributes
     */

    /**
     * Usage statistics for given days
     *
     * @return array Array of History
     */
    public function history(): array
    {
        if (!isset($this->data['history'])) {
            return [];
        }

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\History($data);
        }, $this->data['history']);
    }
}
