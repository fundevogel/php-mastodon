<?php

/**
 * Mastodon OAuth helper library
 *
 * @link https://github.com/Fundevogel/php-mastodon
 * @license https://www.gnu.org/licenses/gpl-3.0.txt GPL v3
 * @version 0.3.0
 */

namespace Fundevogel\Mastodon;

use Fundevogel\Mastodon\Methods\Apps\Apps;
use Fundevogel\Mastodon\Methods\Apps\OAuth;

use Fundevogel\Mastodon\Methods\Accounts\Accounts;
use Fundevogel\Mastodon\Methods\Accounts\Bookmarks;
use Fundevogel\Mastodon\Methods\Accounts\Favourites;
use Fundevogel\Mastodon\Methods\Accounts\Blocks;
use Fundevogel\Mastodon\Methods\Accounts\DomainBlocks;
use Fundevogel\Mastodon\Methods\Accounts\Filters;
use Fundevogel\Mastodon\Methods\Accounts\Reports;
use Fundevogel\Mastodon\Methods\Accounts\FollowRequests;
use Fundevogel\Mastodon\Methods\Accounts\Endorsements;
use Fundevogel\Mastodon\Methods\Accounts\FeaturedTags;
use Fundevogel\Mastodon\Methods\Accounts\Preferences;
use Fundevogel\Mastodon\Methods\Accounts\Suggestions;

use Fundevogel\Mastodon\Methods\Statuses\Statuses;
use Fundevogel\Mastodon\Methods\Statuses\Media;
use Fundevogel\Mastodon\Methods\Statuses\Polls;
use Fundevogel\Mastodon\Methods\Statuses\ScheduledStatuses;

use Fundevogel\Mastodon\Methods\Timelines\Timelines;
use Fundevogel\Mastodon\Methods\Conversations\Conversations;
use Fundevogel\Mastodon\Methods\Conversations\Lists;
use Fundevogel\Mastodon\Methods\Conversations\Markers;

use Fundevogel\Mastodon\Methods\Notifications\Notifications;

use Fundevogel\Mastodon\Methods\Instance\Instance;
use Fundevogel\Mastodon\Methods\Instance\Trends;
use Fundevogel\Mastodon\Methods\Instance\Directory;
use Fundevogel\Mastodon\Methods\Instance\CustomEmojis;

use Fundevogel\Mastodon\Methods\Announcements\Announcements;

use Fundevogel\Mastodon\Methods\Proofs\Proofs;

use Fundevogel\Mastodon\Methods\OEmbed\OEmbed;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException as GuzzleException;


class Api
{
    /**
     * Mastodon instance
     *
     * @var string
     */
    private $instance;


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
    public $headers = [
        'Content-Type' => 'application/json; charset=utf-8',
        'Accept'       => '*/*',
    ];


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
     * @return \Fundevogel\Mastodon\Methods\Apps\Apps;
     */
    public function apps(): \Fundevogel\Mastodon\Methods\Apps\Apps
    {
        return new Apps($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Apps\OAuth;
     */
    public function oauth(): \Fundevogel\Mastodon\Methods\Apps\OAuth
    {
        return new OAuth($this);
    }


    /**
     * 'Accounts'
     */

    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Accounts;
     */
    public function accounts(): \Fundevogel\Mastodon\Methods\Accounts\Accounts
    {
        return new Accounts($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Bookmarks;
     */
    public function bookmarks(): \Fundevogel\Mastodon\Methods\Accounts\Bookmarks
    {
        return new Bookmarks($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Favourites;
     */
    public function favourites(): \Fundevogel\Mastodon\Methods\Accounts\Favourites
    {
        return new Favourites($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Mutes;
     */
    public function mutes(): \Fundevogel\Mastodon\Methods\Accounts\Mutes
    {
        return new Mutes($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Blocks;
     */
    public function blocks(): \Fundevogel\Mastodon\Methods\Accounts\Blocks
    {
        return new Blocks($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\DomainBlocks;
     */
    public function domainBlocks(): \Fundevogel\Mastodon\Methods\Accounts\DomainBlocks
    {
        return new DomainBlocks($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Filters;
     */
    public function filters(): \Fundevogel\Mastodon\Methods\Accounts\Filters
    {
        return new Filters($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Reports;
     */
    public function reports(): \Fundevogel\Mastodon\Methods\Accounts\Reports
    {
        return new Reports($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\FollowRequests;
     */
    public function followRequests(): \Fundevogel\Mastodon\Methods\Accounts\FollowRequests
    {
        return new FollowRequests($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Endorsements;
     */
    public function endorsements(): \Fundevogel\Mastodon\Methods\Accounts\Endorsements
    {
        return new Endorsements($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\FeaturedTags;
     */
    public function featuredTags(): \Fundevogel\Mastodon\Methods\Accounts\FeaturedTags
    {
        return new FeaturedTags($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Preferences;
     */
    public function preferences(): \Fundevogel\Mastodon\Methods\Accounts\Preferences
    {
        return new Preferences($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Suggestions;
     */
    public function suggestions(): \Fundevogel\Mastodon\Methods\Accounts\Suggestions
    {
        return new Suggestions($this);
    }


    /**
     * 'Statuses'
     */

    /**
     * @return \Fundevogel\Mastodon\Methods\Statuses\Statuses;
     */
    public function statuses(): \Fundevogel\Mastodon\Methods\Statuses\Statuses
    {
        return new Statuses($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Statuses\Media;
     */
    public function media(): \Fundevogel\Mastodon\Methods\Statuses\Media
    {
        return new Media($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Statuses\Polls;
     */
    public function polls(): \Fundevogel\Mastodon\Methods\Statuses\Polls
    {
        return new Polls($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Statuses\ScheduledStatuses;
     */
    public function scheduledStatuses(): \Fundevogel\Mastodon\Methods\Statuses\ScheduledStatuses
    {
        return new ScheduledStatuses($this);
    }


    /**
     * 'Timelines'
     */

    /**
     * @return \Fundevogel\Mastodon\Methods\Timelines\Timelines;
     */
    public function timelines(): \Fundevogel\Mastodon\Methods\Timelines\Timelines
    {
        return new Timelines($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Timelines\Conversations;
     */
    public function conversations(): \Fundevogel\Mastodon\Methods\Timelines\Conversations
    {
        return new Conversations($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Timelines\Lists;
     */
    public function lists(): \Fundevogel\Mastodon\Methods\Timelines\Lists
    {
        return new Lists($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Timelines\Markers;
     */
    public function markers(): \Fundevogel\Mastodon\Methods\Timelines\Markers
    {
        return new Markers($this);
    }


    /**
     * 'Instance'
     */

    /**
     * @return \Fundevogel\Mastodon\Methods\Instance\Instance;
     */
    public function instance(): \Fundevogel\Mastodon\Methods\Instance\Instance
    {
        return new Instance($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Instance\Trends;
     */
    public function trends(): \Fundevogel\Mastodon\Methods\Instance\Trends
    {
        return new Trends($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Instance\Directory;
     */
    public function directory(): \Fundevogel\Mastodon\Methods\Instance\Directory
    {
        return new Directory($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Instance\CustomEmojis;
     */
    public function customEmojis(): \Fundevogel\Mastodon\Methods\Instance\CustomEmojis
    {
        return new CustomEmojis($this);
    }


    /**
     * 'Announcements'
     */

    /**
     * @return \Fundevogel\Mastodon\Methods\Announcements\Announcements;
     */
    public function announcements(): \Fundevogel\Mastodon\Methods\Announcements\Announcements
    {
        return new Announcements($this);
    }


    /**
     * 'Proofs'
     */

    /**
     * @return \Fundevogel\Mastodon\Methods\Proofs\Proofs;
     */
    public function proofs(): \Fundevogel\Mastodon\Methods\Proofs\Proofs
    {
        return new Proofs($this);
    }


    /**
     * 'OEmbed'
     */

    /**
     * @return \Fundevogel\Mastodon\Methods\OEmbed\OEmbed;
     */
    public function oembed(): \Fundevogel\Mastodon\Methods\OEmbed\OEmbed
    {
        return new OEmbed($this);
    }
}
