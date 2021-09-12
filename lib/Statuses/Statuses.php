<?php

namespace Fundevogel\Mastodon\Statuses;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Statuses
 *
 * Publish, interact, and view information about statuses
 */
class Statuses extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'statuses';


    /**
     * Publish new status
     *
     * @param string $id
     *
     * @return array
     */
    // public function post(string $id = ''): array
    // {
    //     $endpoint = "{$this->endpoint}/{$id}";

    //     return $this->api->post($endpoint);
    // }


    /**
     * View specific status
     *
     * @param string $id
     *
     * @return array
     */
    public function get(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->get($endpoint);
    }


    /**
     * Delete status
     *
     * @param string $id
     *
     * @return array
     */
    public function delete(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->delete($endpoint);
    }


    /**
     * Parent and child statuses
     *
     * @param string $id
     *
     * @return array
     */
    public function context(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/context";

        return $this->api->get($endpoint);
    }


    /**
     * Boosted by
     *
     * @param string $id
     *
     * @return array
     */
    public function rebloggedBy(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/reblogged_by";

        return $this->api->get($endpoint);
    }


    /**
     * Favourited by
     *
     * @param string $id
     *
     * @return array
     */
    public function favouritedBy(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/favourited_by";

        return $this->api->get($endpoint);
    }


    /**
     * Favourite
     *
     * @param string $id
     *
     * @return array
     */
    public function favourite(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/favourite";

        return $this->api->post($endpoint);
    }


    /**
     * Undo favourite
     *
     * @param string $id
     *
     * @return array
     */
    public function unfavourite(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/unfavourite";

        return $this->api->post($endpoint);
    }


    /**
     * Boost
     *
     * @param string $id
     * @param string $visibility
     *
     * @return array
     */
    public function reblog(string $id, string $visibility = 'public'): array
    {
        $endpoint = "{$this->endpoint}/{$id}/reblog";

        return $this->api->post($endpoint, [
            'visibility' => $visibility,
        ]);
    }


    /**
     * Undo boost
     *
     * @param string $id
     *
     * @return array
     */
    public function unreblog(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/unreblog";

        return $this->api->post($endpoint);
    }


    /**
     * Bookmark
     *
     * @param string $id
     *
     * @return array
     */
    public function bookmark(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/bookmark";

        return $this->api->post($endpoint);
    }


    /**
     * Undo bookmark
     *
     * @param string $id
     *
     * @return array
     */
    public function unbookmark(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/unbookmark";

        return $this->api->post($endpoint);
    }


    /**
     * Mute conversation
     *
     * @param string $id
     *
     * @return array
     */
    public function mute(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/mute";

        return $this->api->post($endpoint);
    }


    /**
     * Unmute conversation
     *
     * @param string $id
     *
     * @return array
     */
    public function unmute(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/unmute";

        return $this->api->post($endpoint);
    }


    /**
     * Pin to profile
     *
     * @param string $id
     *
     * @return array
     */
    public function pin(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/pin";

        return $this->api->post($endpoint);
    }


    /**
     * Unpin to profile
     *
     * @param string $id
     *
     * @return array
     */
    public function unpin(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}/unpin";

        return $this->api->post($endpoint);
    }
}
