<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Status
 *
 * Represents a status posted by an account
 *
 * @see https://docs.joinmastodon.org/entities/status
 */
class Status extends Entity
{
    /**
     * Base attributes
     */

    /**
     * ID of the status in the database
     *
     * @return string
     */
    public function id(): string
    {
        return $this->data['id'];
    }


    /**
     * URI of the status used for federation
     *
     * @return string
     */
    public function uri(): string
    {
        return $this->data['uri'];
    }


    /**
     * The date when this status was created
     *
     * @return string ISO 8601 datetime
     */
    public function createdAt(): string
    {
        return $this->data['created_at'];
    }


    /**
     * The account that authored this status
     *
     * @return \Fundevogel\Mastodon\Entities\Account
     */
    public function account(): \Fundevogel\Mastodon\Entities\Account
    {
        return new \Fundevogel\Mastodon\Entities\Account($this->data['account']);
    }


    /**
     * HTML-encoded status content
     *
     * @return string HTML
     */
    public function content(): string
    {
        return $this->data['content'];
    }


    /**
     * Visibility of this status
     *
     * Enumerable oneOf:
     * `public`   Visible to everyone, shown in public timelines
     * `unlisted` Visible to public, but not included in public timelines
     * `private`  Visible to followers only, and to any mentioned users
     * `direct`   Visible only to mentioned users
     *
     * @return string
     */
    public function visibility(): string
    {
        return $this->data['visibility'];
    }


    /**
     * Is this status marked as sensitive content?
     *
     * @return bool
     */
    public function sensitive(): bool
    {
        return $this->data['sensitive'];
    }


    /**
     * Subject or summary line, below which status content is collapsed until expanded
     *
     * @return string
     */
    public function spoilerText(): string
    {
        return $this->data['spoiler_text'];
    }


    /**
     * Subject or summary line, below which status content is collapsed until expanded
     *
     * @return array Array of Attachment
     */
    public function mediaAttachments(): string
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Attachment($data);
        }, $this->data['media_attachments']);
    }


    /**
     * The application used to post this status
     *
     * @return \Fundevogel\Mastodon\Entities\Application
     */
    public function application(): \Fundevogel\Mastodon\Entities\Application
    {
        return $this->data['application'];
    }


    /**
     * Rendering attributes
     */

    /**
     * Mentions of users within the status content
     *
     * @return array Array of Mention
     */
    public function mentions(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Mention($data);
        }, $this->data['mentions']);
    }


    /**
     * Hashtags used within the status content
     *
     * @return array Array of Tag
     */
    public function tags(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Tag($data);
        }, $this->data['tags']);
    }


    /**
     * Custom emoji to be used when rendering status content
     *
     * @return array Array of Emoji
     */
    public function emojis(): array
    {
        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Tag($data);
        }, $this->data['emojis']);
    }


    /**
     * Informational attributes
     */

    /**
     * How many boosts this status has received
     *
     * @return int
     */
    public function reblogsCount(): int
    {
        return $this->data['reblogs_count'];
    }


    /**
     * How many favourites this status has received
     *
     * @return int
     */
    public function favouritesCount(): int
    {
        return $this->data['favourites_count'];
    }


    /**
     * How many replies this status has received
     *
     * @return int
     */
    public function repliesCount(): int
    {
        return $this->data['replies_count'];
    }


    /**
     * Nullable attributes
     */

    /**
     * A link to the status's HTML representation
     *
     * @return null|string
     */
    public function url()
    {
        return $this->data['url'];
    }


    /**
     * ID of the status being replied
     *
     * @return null|string
     */
    public function inReplyToID()
    {
        return $this->data['in_reply_to_id'];
    }


    /**
     * The status being reblogged
     *
     * @return null|\Fundevogel\Mastodon\Entities\Status Status
     */
    public function reblog()
    {
        return is_array($this->data['reblog'])
            ? new \Fundevogel\Mastodon\Entities\Status($this->data['reblog'])
            : null
        ;
    }


    /**
     * The poll attached to the status
     *
     * @return null|\Fundevogel\Mastodon\Entities\Poll Poll
     */
    public function poll()
    {
        return is_array($this->data['poll'])
            ? new \Fundevogel\Mastodon\Entities\Poll($this->data['poll'])
            : null
        ;
    }


    /**
     * Preview card for links included within status content
     *
     * @return null|\Fundevogel\Mastodon\Entities\Card Card
     */
    public function card()
    {
        return is_array($this->data['card'])
            ? new \Fundevogel\Mastodon\Entities\Card($this->data['card'])
            : null
        ;
    }


    /**
     * Primary language of this status
     *
     * @return null|string ISO 639-1 language two-letter code
     */
    public function language()
    {
        return $this->data['language'];
    }


    /**
     * Plain-text source of a status
     *
     * Returned instead of `content` when status is deleted,
     * so the user may redraft from the source text without
     * the client having to reverse-engineer the original
     * text from the HTML content.
     *
     * @return null|string
     */
    public function text()
    {
        return $this->data['text'];
    }


    /**
     * Authorized user attributes
     */

    /**
     * Have you favourited this status?
     *
     * @return bool
     */
    public function favourited(): bool
    {
        return $this->data['favourited'];
    }


    /**
     * Have you boosted this status?
     *
     * @return bool
     */
    public function reblogged(): bool
    {
        return $this->data['reblogged'];
    }


    /**
     * Have you muted notifications for this status's conversation?
     *
     * @return bool
     */
    public function muted(): bool
    {
        return $this->data['muted'];
    }


    /**
     * Have you bookmarked this status?
     *
     * @return bool
     */
    public function bookmarked(): bool
    {
        return $this->data['bookmarked'];
    }


    /**
     * Have you pinned this status?
     *
     * Only appears if the status is pinnable
     *
     * @return bool
     */
    public function pinned(): bool
    {
        return $this->data['pinned'];
    }


    /**
     * Custom methods
     */

    /**
     * Enable media downloads
     */
    use \Fundevogel\Mastodon\Traits\Downloader;


    /**
     * Downloads media attachments
     *
     * @param string $directory Download directory
     * @param bool $overwrite Whether existing file should be overwritten
     *
     * @return array Names of all downloaded files
     */
    public function downloadMedia(string $directory, bool $overwrite = false): array
    {
        # Log downloaded files
        $downloads = [];

        # Loop over media attachments
        foreach ($this->data['media_attachments'] as $media) {
            try {
                # Download original files
                $file = basename($media['url']);

                if ($this->download($media['url'], $directory, $file, $overwrite)) {
                    $downloads[] = $file;
                }

            } catch (\Exception $e) {}
        }

        return $downloads;
    }
}
