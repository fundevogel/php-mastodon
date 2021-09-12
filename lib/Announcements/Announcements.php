<?php

namespace Fundevogel\Mastodon\Announcements;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Announcements
 *
 * For announcements set by administration
 */
class Announcements extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'announcements';


    /**
     * View all announcements
     *
     * See all currently active announcements set by admins
     *
     * @param bool $withDismissed If true, response will include announcements dismissed by the user
     *
     * @return array Array of Announcement
     */
    public function get(bool $withDismissed = false): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'with_dismissed' => $withDismissed,
        ]);
    }


    /**
     * Dismiss an announcement
     *
     * Allows a user to mark the announcement as read
     *
     * @param string $id Local ID of an announcement in the database
     *
     * @return array Empty
     */
    public function dismiss(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/dismiss";

        return $this->api->post($endpoint, [
            'with_dismissed' => $withDismissed,
        ]);
    }


    /**
     * Add reaction
     *
     * React to an announcement with an emoji
     *
     * @param string $id Local ID of an announcement in the database
     * @param string $name Unicode emoji, or shortcode of custom emoji
     *
     * @return array Empty
     */
    public function addReaction(string $id, string $name): array
    {
        $endpoint = "{$this->endpoint}/{$id}/reactions/{$name}";

        return $this->api->put($endpoint);
    }


    /**
     * Remove reaction
     *
     * Undo a react emoji to an announcement
     *
     * @param string $id Local ID of an announcement in the database
     * @param string $name Unicode emoji, or shortcode of custom emoji
     *
     * @return array Empty
     */
    public function removeReaction(string $id, string $name): array
    {
        $endpoint = "{$this->endpoint}/{$id}/reactions/{$name}";

        return $this->api->delete($endpoint);
    }
}
