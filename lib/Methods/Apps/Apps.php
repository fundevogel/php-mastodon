<?php

namespace Fundevogel\Mastodon\Methods\Apps;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Apps
 *
 * Registers client applications that can be used to obtain OAuth tokens
 *
 * @see https://docs.joinmastodon.org/methods/apps
 */
class Apps extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'apps';


    /**
     * Create an application
     *
     * Create a new application to obtain OAuth2 credentials
     *
     * @param string $clientName A name for your application
     * @param string $redirectURIs Where the user should be redirected after authorization. To display the authorization code to the user instead of redirecting to a web page, use `urn:ietf:wg:oauth:2.0:oob` in this parameter
     * @param string $scopes Space separated list of scopes
     * @param string $website A URL to the homepage of your app
     *
     * @return \Fundevogel\Mastodon\Entities\Application Application, with `client_id` and `client_secret`
     */
    public function create(string $clientName, string $redirectURIs, string $scopes = 'read', string $website = ''): \Fundevogel\Mastodon\Entities\Application
    {
        $endpoint = "{$this->endpoint}";

        return new \Fundevogel\Mastodon\Entities\Application($this->api->post($endpoint, [
            'client_name'   => $clientName,
            'redirect_uris' => $redirectURIs,
            'scopes'        => $scopes,
            'website'       => $website,
        ]));
    }


    /**
     * Verify your app works
     *
     * Confirm that the app's OAuth2 credentials work
     *
     * @param string $clientName
     * @param string $redirectURIs
     * @param string $scopes
     * @param string $website
     *
     * @return \Fundevogel\Mastodon\Entities\Application Application
     */
    public function verifyCredentials(): \Fundevogel\Mastodon\Entities\Application
    {
        $endpoint = "{$this->endpoint}/verify_credentials";

        return new \Fundevogel\Mastodon\Entities\Application($this->api->post($endpoint));
    }
}
