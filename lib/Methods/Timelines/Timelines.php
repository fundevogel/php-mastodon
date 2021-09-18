<?php

namespace Fundevogel\Mastodon\Methods\Timelines;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Timelines
 *
 * Read and view timelines of statuses
 *
 * @see https://docs.joinmastodon.org/methods/timelines
 */
class Timelines extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'timelines';


    /**
     * Public timeline
     *
     * @param bool $local Show only local statuses?
     * @param bool $remote Show only remote statuses?
     * @param bool $onlyMedia Show only statuses with media attached?
     * @param string $maxID Return results older than this id
     * @param string $sinceID Return results newer than this id
     * @param string $minID Return results immediately newer than this id
     * @param int $limit Maximum number of results to return. Defaults to 20
     *
     * @return array Array of Status
     */
    public function public(bool $local = false, bool $remote = false, bool $onlyMedia = false, string $maxID, string $sinceID, string $minID, int $limit = 20): array
    {
        $endpoint = "{$this->endpoint}/public";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Status($data);
        }, $this->api->get($endpoint, [
            'local'      => $local,
            'remote'     => $remote,
            'only_media' => $onlyMedia,
            'max_id'     => $maxID,
            'since_id'   => $sinceID,
            'min_id'     => $minID,
            'limit'      => $limit,
        ]));
    }


    /**
     * Hashtag timeline
     *
     * View public statuses containing the given hashtag
     *
     * @param bool $hashtag Content of a #hashtag, not including # symbol
     * @param bool $local Show only local statuses?
     * @param bool $onlyMedia Show only statuses with media attached?
     * @param string $maxID Return results older than this ID
     * @param string $sinceID Return results newer than this ID
     * @param string $minID Return results immediately newer than this ID
     * @param int $limit Maximum number of results to return. Defaults to 20
     *
     * @return array Array of Status
     */
    public function tag(string $hashtag, bool $local = false, bool $onlyMedia = false, string $maxID, string $sinceID, string $minID, int $limit = 20): array
    {
        $endpoint = "{$this->endpoint}/tag/{$hashtag}";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Status($data);
        }, $this->api->get($endpoint, [
            'local'      => $local,
            'only_media' => $onlyMedia,
            'max_id'     => $maxID,
            'since_id'   => $sinceID,
            'min_id'     => $minID,
            'limit'      => $limit,
        ]));
    }


    /**
     * Home timeline
     *
     * View statuses from followed users
     *
     * @param bool $local Show only local statuses?
     * @param string $maxID Return results older than this ID
     * @param string $sinceID Return results newer than this ID
     * @param string $minID Return results immediately newer than this ID
     * @param int $limit Maximum number of results to return
     *
     * @return array Array of Status
     */
    public function home(bool $local = false, string $maxID, string $sinceID, string $minID, int $limit = 20): array
    {
        $endpoint = "{$this->endpoint}/home";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Status($data);
        }, $this->api->get($endpoint, [
            'local'    => $local,
            'max_id'   => $maxID,
            'since_id' => $sinceID,
            'min_id'   => $minID,
            'limit'    => $limit,
        ]));
    }


    /**
     * List timeline
     *
     * View statuses in the given list timeline
     *
     * @param string $id Local ID of the list in the database
     * @param string $maxID Return results older than this ID
     * @param string $sinceID Return results newer than this ID
     * @param string $minID Return results immediately newer than this ID
     * @param int $limit Maximum number of results to return
     *
     * @return array Array of Status
     */
    public function list(string $id, string $maxID = '', string $sinceID = '', string $minID = '', int $limit = 20): array
    {
        $endpoint = "{$this->endpoint}/list/{$id}";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Status($data);
        }, $this->api->get($endpoint, [
            'max_id'   => $maxID,
            'since_id' => $sinceID,
            'min_id'   => $minID,
            'limit'    => $limit,
        ]));
    }
}
