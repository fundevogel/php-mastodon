<?php

/**
 * Mastodon OAuth helper library
 *
 * @link https://github.com/Fundevogel/php-mastodon
 * @license https://www.gnu.org/licenses/gpl-3.0.txt GPL v3
 * @version 0.5.3
 */

namespace Fundevogel\Mastodon;


class Api
{
    /**
     * HTTP handler
     *
     * @var \GuzzleHttp\Client
     */
    private $client;


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
     * Name of application
     *
     * @var string
     */
    public $appName = 'Test App';


    /**
     * Website of application
     *
     * @var string
     */
    public $appURL = '';


    /**
     * Client key of application
     *
     * @var string
     */
    public $clientKey = '';


    /**
     * Client secret of application
     *
     * @var string
     */
    public $clientSecret = '';


    /**
     * Access token of application
     *
     * @var string
     */
    public $accessToken = '';


    /**
     * ID of currently active account
     *
     * @var string
     */
    private $id = '';


    /**
     * Constructor
     *
     * @param string $instance Instance name
     *
     * @return void
     */
    public function __construct(string $instance = 'mastodon.social')
    {
        # Initialize HTTP handler
        $this->client = new \GuzzleHttp\Client();

        # Set instance
        $this->instance = $instance;
    }


    /**
     * Logs in with an account
     *
     * @param string $authCode
     *
     * @return bool Whether logging in was successful
     */
    public function logIn(string $authCode = ''): bool
    {
        # Attempt login ..
        try {
            # Authorize with API, receiving account-level or application-level access
            # Check for access token already provided ..
            if (empty($this->accessToken)) {
                # .. otherwise, see if necessary ingredients already provided ..
                if (empty($this->clientKey) && empty($this->clientSecret)) {
                    # .. otherwise, create an application to get them ..
                    $application = $this->apps()->create($this->appName, 'urn:ietf:wg:oauth:2.0:oob', implode(' ', $this->scope), $this->appURL);

                    # .. and store them for later use
                    $this->clientKey = $application->clientID();
                    $this->clientSecret = $application->clientSecret();
                }

                # Fallback to application-level access
                $grantType = 'client_credentials';

                # Check if authorization token was provided, and if so ..
                if (!empty($authCode)) {
                    # .. attempt to get account-level access
                    $grantType = 'authorization_code';
                }

                # Obtain access token
                $token = $this->oauth()->token($this->clientKey, $this->clientSecret, $grantType, $authCode);

                # If successful ..
                if ($token->hasAccessToken()) {
                    # .. store it for later
                    $this->accessToken = $token->accessToken();
                }
            }

            # If we got account-level access ..
            if ($account = $this->accounts()->verifyCredentials()) {
                # .. attempt to obtain ID for current account
                $this->id = $account->id();
            }

            return true;

        # .. while errors of any kind lead to an unsuccessful call
        } catch (\Exception $e) {}

        return false;
    }


    /**
     * Logs out of an account
     *
     * @return bool Whether logging out was successful
     */
    public function logOut(): bool
    {
        # Revoke access token
        $tokenEntity = $this->oauth()->revoke($this->clientKey, $this->clientSecret, $this->accessToken);

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
     * Builds URL for API endpoint
     *
     * @param string $endpoint
     * @param array $query
     *
     * @return string
     */
    private function buildURL(string $endpoint, array $query): string
    {
        # Build base URL from given components
        # (1) Set API as default URL
        $url = "https://{$this->instance}/{$this->namespace}/{$this->version}/{$endpoint}";

        # (2) Check for OAuth & other non-compliant endpoints ..
        if (strpos($endpoint, 'oauth/') === 0 || strpos($endpoint, 'api/') === 0) {
            # .. being made directly from base URL
            $url = "https://{$this->instance}/{$endpoint}";
        }

        # Add query parameters
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $url;
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
        # Build request
        # (1) Determine base URL
        $url = $this->buildURL($endpoint, $query);

        # (2) Determine HTTP headers
        $headers = array_merge($this->headers, $headers);

        if (!empty($this->accessToken)) {
            $headers['Authorization'] = "Bearer {$this->accessToken}";
        }

        try {
            # Send request
            $response = $this->client->request($method, $url, ['headers' => $headers]);

            if (empty($data = json_decode($response->getBody(), true))) {
                return [];
            }

            if ($response->getStatusCode() == 200) {
                return $data;
            }

            # Check for error message
            # TODO: Add custom `Exception`s
            if (in_array('error', array_keys($data)) === true) {
                # These typically come with an error message:
                # 401 - Unauthorized
                # 403 - Forbidden
                # 404 - Not Found
                # 422 - Unprocessable Entity
                # 500
                throw new \Exception($data['error']);
            }

        } catch (\GuzzleHttp\Exception\ClientException $e) {}

        return [];
    }


    /**
     * Determines URL for receiving an authorization code
     *
     * @param string $clientKey Client key of application
     *
     * @return string
     */
    public function getAuthUrl(string $clientKey = ''): string
    {
        # Build query parameters
        # (1) Determine client ID
        if (empty($clientKey)) {
            $clientKey = $this->clientKey;
        }

        # (2) Put everything together
        $query = [
            'client_id' => $clientKey,
            'scope'         => implode(' ', $this->scope),
            'redirect_uri'  => 'urn:ietf:wg:oauth:2.0:oob',
            'force_login'   => false,
            'response_type' => 'code',
        ];

        # Prepare result
        $result = '';

        # Determine URL for obtaining an authorization code
        $this->client->get($this->buildURL('oauth/authorize', $query), [
            'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$result) {
                $result = $stats->getEffectiveUri();
            },
        ]);

        return $result;
    }


    /**
     * Get current account ID
     */
    public function id(): string
    {
        return $this->id;
    }


    /**
     * API methods
     */

    /**
     * 'Apps'
     */

    use \Fundevogel\Mastodon\Traits\Methods\Apps;


    /**
     * 'Accounts'
     */

    use \Fundevogel\Mastodon\Traits\Methods\Accounts;


    /**
     * 'Statuses'
     */

    use \Fundevogel\Mastodon\Traits\Methods\Statuses;


    /**
     * 'Timelines'
     */

    use \Fundevogel\Mastodon\Traits\Methods\Timelines;


    /**
     * 'Notifications'
     */

    use \Fundevogel\Mastodon\Traits\Methods\Notifications;


    /**
     * 'Instance'
     */

    use \Fundevogel\Mastodon\Traits\Methods\Instance;


    /**
     * 'Announcements'
     */

    use \Fundevogel\Mastodon\Traits\Methods\Announcements;


    /**
     * 'Proofs'
     */

    use \Fundevogel\Mastodon\Traits\Methods\Proofs;


    /**
     * 'OEmbed'
     */

    use \Fundevogel\Mastodon\Traits\Methods\OEmbed;
}
