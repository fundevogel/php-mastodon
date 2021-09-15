<?php

/**
 * Mastodon OAuth helper library
 *
 * @link https://github.com/Fundevogel/php-mastodon
 * @license https://www.gnu.org/licenses/gpl-3.0.txt GPL v3
 * @version 0.3.0
 */

namespace Fundevogel\Mastodon;


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
        $client = new \GuzzleHttp\Client();

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

        } catch (\GuzzleHttp\Exception\ClientException $e) {}

        return [];
    }


    /**
     * API methods
     */

    /**
     * 'Apps'
     */

    use \Fundevogel\Mastodon\Traits\Apps;


    /**
     * 'Accounts'
     */

    use \Fundevogel\Mastodon\Traits\Accounts;


    /**
     * 'Statuses'
     */

    use \Fundevogel\Mastodon\Traits\Statuses;


    /**
     * 'Timelines'
     */

    use \Fundevogel\Mastodon\Traits\Timelines;


    /**
     * 'Notifications'
     */

    use \Fundevogel\Mastodon\Traits\Notifications;


    /**
     * 'Instance'
     */

    use \Fundevogel\Mastodon\Traits\Instance;


    /**
     * 'Announcements'
     */

    use \Fundevogel\Mastodon\Traits\Announcements;


    /**
     * 'Proofs'
     */

    use \Fundevogel\Mastodon\Traits\Proofs;


    /**
     * 'OEmbed'
     */

    use \Fundevogel\Mastodon\Traits\OEmbed;
}
