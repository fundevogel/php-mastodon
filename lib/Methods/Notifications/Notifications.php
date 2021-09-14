<?php

namespace Fundevogel\Mastodon\Methods\Notifications;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Notifications
 *
 * Receive notifications for activity on your account or statuses
 */
class Notifications extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'notifications';


    /**
     * Get all notifications
     *
     * Notifications concerning the user
     *
     * This API returns Link headers containing links to the next/previous
     * page. However, the links can also be constructed dynamically using
     * query params and `id` values.
     *
     * @param string $maxID Return results older than this ID
     * @param string $sinceID Return results newer than this ID
     * @param string $minID Return results immediately newer than this ID
     * @param int $limit Maximum number of results to return
     * @param array $exludeTypes Array of types to exclude (`follow`, `favourite`, `reblog`, `mention`, `poll`, `follow_request`)
     * @param string $accountID Return only notifications received from this account
     *
     * @return array Array of Notification
     */
    public function all(string $maxID, string $sinceID, string $minID, int $limit = 20, array $exludeTypes = [], string $accountID = ''): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint, [
            'max_id'        => $maxID,
            'since_id'      => $sinceID,
            'min_id'        => $minID,
            'limit'         => $limit,
            'exclude_types' => $exludeTypes,
            'account_id'    => $accountID,
        ]);
    }


    /**
     * Get a single notification
     *
     * View information about a notification with a given ID
     *
     * @param string $id ID of the notification in the database
     *
     * @return array Notification
     */
    public function get(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->get($endpoint);
    }


    /**
     * Dismiss all notifications
     *
     * Clear all notifications from the server
     *
     * @return array empty object
     */
    public function clear(): array
    {
        $endpoint = "{$this->endpoint}/clear";

        return $this->api->post($endpoint);
    }


    /**
     * Dismiss a single notification
     *
     * Clear a single notification from the server
     *
     * @param string $id ID of the notification to be cleared
     *
     * @return array empty object
     */
    public function dismiss(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/dismiss";

        return $this->api->post($endpoint);
    }
}
