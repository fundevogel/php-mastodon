<?php

/**
 * Mastodon OAuth helper library
 *
 * @link https://github.com/Fundevogel/php-mastodon
 * @license https://www.gnu.org/licenses/gpl-3.0.txt GPL v3
 * @version 0.2.1
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
    public $instance;


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


    /**
     * ID of currently active account
     *
     * @var string
     */
    public $id;


    /**
     * Constructor
     *
     * @param string $instance Instance name
     *
     * @return void
     */
    public function __construct(string $instance = 'mastodon.social')
    {
        # Set instance
        $this->instance = $instance;
    }


    /**
     * Logs in with an account
     *
     * @param string $clientID Client ID, obtained during app registration
     * @param string $clientSecret Client secret, obtained during app registration
     *
     * @return bool Whether logging in was successful
     */
    public function logIn(string $clientID = '', string $clientSecret = ''): bool
    {
        # If access token not already defined ..
        if (empty($this->accessToken)) {
            # .. attempt to obtain one
            $tokenEntity = $this->oauth()->token($clientID, $clientSecret);

            # If successful ..
            if (isset($tokenEntity['access_token'])) {
                # .. store it for later
                $this->accessToken = $tokenEntity['access_token'];
            }
        }

        # Verify authorization
        if ($data = $this->accounts()->verifyCredentials()) {
            $this->id = $data['id'];
        }

        return empty($this->id) === false;
    }


    /**
     * Logs out of an account
     *
     * @param string $clientID Client ID, obtained during app registration
     * @param string $clientSecret Client secret, obtained during app registration
     *
     * @return bool Whether logging out was successful
     */
    public function logOut(string $clientID = '', string $clientSecret = ''): bool
    {
        # Revoke access token
        $tokenEntity = $this->oauth()->revoke($clientID, $clientSecret, $this->accessToken);

        if (empty($tokenEntity)) {
            # Reset relevant data
            # (1) Access token
            $this->accessToken = '';

            # (2) Account ID
            $this->id = '';

            return true;
        }

        return false;
    }


    /**
     * Sends GET request
     *
     * @param string $endpoint
     * @param array $query
     * @param array $headers
     * @param array $errors
     *
     * @return array
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
     *
     * @return array
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
     *
     * @return array
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
     *
     * @return array
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
     *
     * @return array
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
     *
     * @return array
     * @throws Exception
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

        # (2) .. HTTP headers
        $headers = array_merge($this->headers, $headers);

        if (!empty($this->accessToken)) {
            $headers['Accept'] = 'application/json';
            $headers['Authorization'] = "Bearer {$this->accessToken}";
        }

        try {
            # Send request
            $response = $client->request($method, $url, ['headers' => $headers]);

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

    /**
     * @return \Fundevogel\Mastodon\Apps\Apps;
     */
    public function apps(): \Fundevogel\Mastodon\Apps\Apps
    {
        return new Apps($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Apps\OAuth;
     */
    public function oauth(): \Fundevogel\Mastodon\Apps\OAuth
    {
        return new OAuth($this);
    }


    /**
     * 'Accounts'
     */

    /**
     * @return \Fundevogel\Mastodon\Accounts\Accounts;
     */
    public function accounts(): \Fundevogel\Mastodon\Accounts\Accounts
    {
        return new Accounts($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\Bookmarks;
     */
    public function bookmarks(): \Fundevogel\Mastodon\Accounts\Bookmarks
    {
        return new Bookmarks($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\Favourites;
     */
    public function favourites(): \Fundevogel\Mastodon\Accounts\Favourites
    {
        return new Favourites($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\Mutes;
     */
    public function mutes(): \Fundevogel\Mastodon\Accounts\Mutes
    {
        return new Mutes($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\Blocks;
     */
    public function blocks(): \Fundevogel\Mastodon\Accounts\Blocks
    {
        return new Blocks($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\DomainBlocks;
     */
    public function domainBlocks(): \Fundevogel\Mastodon\Accounts\DomainBlocks
    {
        return new DomainBlocks($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\Filters;
     */
    public function filters(): \Fundevogel\Mastodon\Accounts\Filters
    {
        return new Filters($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\Reports;
     */
    public function reports(): \Fundevogel\Mastodon\Accounts\Reports
    {
        return new Reports($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\FollowRequests;
     */
    public function followRequests(): \Fundevogel\Mastodon\Accounts\FollowRequests
    {
        return new FollowRequests($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\Endorsements;
     */
    public function endorsements(): \Fundevogel\Mastodon\Accounts\Endorsements
    {
        return new Endorsements($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\FeaturedTags;
     */
    public function featuredTags(): \Fundevogel\Mastodon\Accounts\FeaturedTags
    {
        return new FeaturedTags($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\Preferences;
     */
    public function preferences(): \Fundevogel\Mastodon\Accounts\Preferences
    {
        return new Preferences($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Accounts\Suggestions;
     */
    public function suggestions(): \Fundevogel\Mastodon\Accounts\Suggestions
    {
        return new Suggestions($this);
    }


    /**
     * 'Statuses'
     */

    /**
     * @return \Fundevogel\Mastodon\Statuses\Statuses;
     */
    public function statuses(): \Fundevogel\Mastodon\Statuses\Statuses
    {
        return new Statuses($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Statuses\Media;
     */
    public function media(): \Fundevogel\Mastodon\Statuses\Media
    {
        return new Media($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Statuses\Polls;
     */
    public function polls(): \Fundevogel\Mastodon\Statuses\Polls
    {
        return new Polls($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Statuses\ScheduledStatuses;
     */
    public function scheduledStatuses(): \Fundevogel\Mastodon\Statuses\ScheduledStatuses
    {
        return new ScheduledStatuses($this);
    }


    /**
     * 'Timelines'
     */

    /**
     * @return \Fundevogel\Mastodon\Timelines\Timelines;
     */
    public function timelines(): \Fundevogel\Mastodon\Timelines\Timelines
    {
        return new Timelines($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Timelines\Conversations;
     */
    public function conversations(): \Fundevogel\Mastodon\Timelines\Conversations
    {
        return new Conversations($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Timelines\Lists;
     */
    public function lists(): \Fundevogel\Mastodon\Timelines\Lists
    {
        return new Lists($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Timelines\Markers;
     */
    public function markers(): \Fundevogel\Mastodon\Timelines\Markers
    {
        return new Markers($this);
    }


    /**
     * 'Instance'
     */

    /**
     * @return \Fundevogel\Mastodon\Instance\Instance;
     */
    public function instance(): \Fundevogel\Mastodon\Instance\Instance
    {
        return new Instance($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Instance\Trends;
     */
    public function trends(): \Fundevogel\Mastodon\Instance\Trends
    {
        return new Trends($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Instance\Directory;
     */
    public function directory(): \Fundevogel\Mastodon\Instance\Directory
    {
        return new Directory($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Instance\CustomEmojis;
     */
    public function customEmojis(): \Fundevogel\Mastodon\Instance\CustomEmojis
    {
        return new CustomEmojis($this);
    }


    /**
     * 'Announcements'
     */

    /**
     * @return \Fundevogel\Mastodon\Announcements\Announcements;
     */
    public function announcements(): \Fundevogel\Mastodon\Announcements\Announcements
    {
        return new Announcements($this);
    }


    /**
     * 'Proofs'
     */

    /**
     * @return \Fundevogel\Mastodon\Proofs\Proofs;
     */
    public function proofs(): \Fundevogel\Mastodon\Proofs\Proofs
    {
        return new Proofs($this);
    }


    /**
     * 'OEmbed'
     */

    /**
     * @return \Fundevogel\Mastodon\OEmbed\OEmbed;
     */
    public function oembed(): \Fundevogel\Mastodon\OEmbed\OEmbed
    {
        return new OEmbed($this);
    }
}
