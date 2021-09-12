<?php

/**
 * Mastodon OAuth helper library
 *
 * @link https://github.com/Fundevogel/php-mastodon
 * @license https://www.gnu.org/licenses/gpl-3.0.txt GPL v3
 * @version 0.1.0
 */

namespace Fundevogel\Mastodon;

use Fundevogel\Mastodon\Apps\Apps;
use Fundevogel\Mastodon\Apps\OAuth;

use Fundevogel\Mastodon\Accounts\Accounts;
use Fundevogel\Mastodon\Accounts\Bookmarks;
use Fundevogel\Mastodon\Accounts\Favourites;
use Fundevogel\Mastodon\Accounts\Blocks;
use Fundevogel\Mastodon\Accounts\DomainBlocks;
use Fundevogel\Mastodon\Accounts\Filters;
use Fundevogel\Mastodon\Accounts\Reports;
use Fundevogel\Mastodon\Accounts\FollowRequests;
use Fundevogel\Mastodon\Accounts\Endorsements;
use Fundevogel\Mastodon\Accounts\FeaturedTags;
use Fundevogel\Mastodon\Accounts\Preferences;
use Fundevogel\Mastodon\Accounts\Suggestions;

use Fundevogel\Mastodon\Statuses\Statuses;
use Fundevogel\Mastodon\Statuses\Media;
use Fundevogel\Mastodon\Statuses\Polls;
use Fundevogel\Mastodon\Statuses\ScheduledStatuses;

use Fundevogel\Mastodon\Timelines\Timelines;
use Fundevogel\Mastodon\Conversations\Conversations;
use Fundevogel\Mastodon\Conversations\Lists;
use Fundevogel\Mastodon\Conversations\Markers;

use Fundevogel\Mastodon\Notifications\Notifications;

use Fundevogel\Mastodon\Instance\Instance;
use Fundevogel\Mastodon\Instance\Trends;
use Fundevogel\Mastodon\Instance\Directory;
use Fundevogel\Mastodon\Instance\CustomEmojis;

use Fundevogel\Mastodon\Announcements\Announcements;

use Fundevogel\Mastodon\Proofs\Proofs;

use Fundevogel\Mastodon\OEmbed\OEmbed;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException as GuzzleException;


class Api
{
    /**
     * Mastodon instance
     *
     * @var string
     */
    public $instance = 'mastodon.social';


    /**
     * API namespace
     *
     * @var string
     */
    private $namespace = 'api';


    /**
     * API version
     *
     * @var string
     */
    private $version = 'v1';


    /**
     * Request headers
     *
     * @var array
     */
    public $headers = [];


    /**
     * Scope of permissions for application
     *
     * @var array
     */
    public $scope = ['read'];


    /**
     * Access token of application
     *
     * @var string
     */
    public $accessToken;


    // public function __contruct() {
    //     return;
    // }


    /**
     * Sends GET request
     *
     * @param string $endpoint
     * @param array $query
     * @param array $headers
     * @param array $errors
     */
    public function get(string $endpoint, array $query = [], array $headers = [], $errors = []): array
    {
        return $this->request('GET', $endpoint, $query, $headers, $errors);
    }


    /**
     * Sends POST request
     *
     * @param string $endpoint
     * @param array $query
     * @param array $headers
     * @param array $errors
     */
    public function post(string $endpoint, array $query = [], array $headers = [], $errors = []): array
    {
        return $this->request('POST', $endpoint, $query, $headers, $errors);
    }


    /**
     * Sends PUT request
     *
     * @param string $endpoint
     * @param array $query
     * @param array $headers
     * @param array $errors
     */
    public function put(string $endpoint, array $query = [], array $headers = [], $errors = []): array
    {
        return $this->request('PUT', $endpoint, $query, $headers, $errors);
    }


    /**
     * Sends PATCH request
     *
     * @param string $endpoint
     * @param array $query
     * @param array $headers
     * @param array $errors
     */
    public function patch(string $endpoint, array $query = [], array $headers = [], $errors = []): array
    {
        return $this->request('PATCH', $endpoint, $query, $headers, $errors);
    }


    /**
     * Sends DELETE request
     *
     * @param string $endpoint
     * @param array $query
     * @param array $headers
     * @param array $errors
     */
    public function delete(string $endpoint, array $query = [], array $headers = [], $errors = []): array
    {
        return $this->request('DELETE', $endpoint, $query, $headers, $errors);
    }


    /**
     * Builds & sends specified request
     *
     * @param string $method
     * @param string $endpoint
     * @param array $query
     * @param array $headers
     * @param array $errors
     */
    private function request(string $method, string $endpoint, array $query, array $headers, $errors): array
    {
        # TODO: Move client to __construct
        $client = new GuzzleClient();

        # Build base URL
        # (1) Set API as default URL
        $url = "https://{$this->instance}/{$this->namespace}/{$this->version}/{$endpoint}";

        # (2) Check for OAuth & other non-compliant endpoints ..
        if (strpos($endpoint, 'oauth/') === 0 || strpos($endpoint, 'api/') === 0) {
            # .. being made directly from base URL
            $url = "https://{$this->instance}/{$endpoint}";
        }

        # Prepare request, using
        # (1) .. query parameters
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        var_dump($url);

        # (2) .. HTTP headers
        if (!empty($this->accessToken)) {
            $headers['Accept'] = 'application/json';
            $headers['Authorization'] = "Bearer {$this->accessToken}";
        }

        var_dump($headers);

        try {
            # Send request
            $response = $client->request($method, $url, ['headers' => $headers]);
            var_dump($response->getStatusCode());
            var_dump($response->getBody());

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody(), true);
            }

            $data = json_decode($response->getBody(), true);

            # Check for error message
            # TODO: Add custom `Exception`s
            if (in_array('error', array_keys($data)) === true) {
                # These typically come with an error message:
                # 401 - Unauthorized
                # 403 - Forbidden
                # 404 - Not Found
                # 422 - Unprocessable Entity
                # 500
                throw new Exception($data['error']);
            }

        } catch (GuzzleException $e) {}

        return [];
    }


    /**
     * API methods
     */

    /**
     * 'Apps'
     */

    public function apps()
    {
        return new Apps($this);
    }


    public function oauth()
    {
        return new OAuth($this);
    }


    /**
     * 'Accounts'
     */

    public function accounts()
    {
        return new Accounts($this);
    }


    public function bookmarks()
    {
        return new Bookmarks($this);
    }


    public function favourites()
    {
        return new Favourites($this);
    }


    public function mutes()
    {
        return new Mutes($this);
    }


    public function blocks()
    {
        return new Blocks($this);
    }


    public function domainBlocks()
    {
        return new DomainBlocks($this);
    }


    public function filters()
    {
        return new Filters($this);
    }


    public function reports()
    {
        return new Reports($this);
    }


    public function followRequests()
    {
        return new FollowRequests($this);
    }


    public function endorsements()
    {
        return new Endorsements($this);
    }


    public function featuredTags()
    {
        return new FeaturedTags($this);
    }


    public function preferences()
    {
        return new Preferences($this);
    }


    public function suggestions()
    {
        return new Suggestions($this);
    }


    /**
     * 'Statuses'
     */

    public function statuses()
    {
        return new Statuses($this);
    }


    public function media()
    {
        return new Media($this);
    }


    public function polls()
    {
        return new Polls($this);
    }


    public function scheduledStatuses()
    {
        return new ScheduledStatuses($this);
    }


    /**
     * 'Timelines'
     */

    public function timelines()
    {
        return new Timelines($this);
    }


    public function conversations()
    {
        return new Conversations($this);
    }


    public function lists()
    {
        return new Lists($this);
    }


    public function markers()
    {
        return new Markers($this);
    }


    /**
     * 'Instance'
     */

    public function instance()
    {
        return new Instance($this);
    }


    public function trends()
    {
        return new Trends($this);
    }


    public function directory()
    {
        return new Directory($this);
    }


    public function customEmojis()
    {
        return new CustomEmojis($this);
    }


    /**
     * 'Announcements'
     */

    public function Announcements()
    {
        return new announcements($this);
    }


    /**
     * 'Proofs'
     */

    public function proofs()
    {
        return new Proofs($this);
    }


    /**
     * 'OEmbed'
     */

    public function oembed()
    {
        return new OEmbed($this);
    }
}
