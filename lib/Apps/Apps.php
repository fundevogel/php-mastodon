<?php

namespace Fundevogel\Mastodon\Apps;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Apps
 *
 * Registers client applications that can be used to obtain OAuth tokens
 */
class Apps extends ApiMethod
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
     * @param string $clientName
     * @param string $redirectURIs
     * @param string $scopes
     * @param string $website
     *
     * @return array Application, with `client_id` and `client_secret`
     */
    public function create(string $clientName, string $redirectURIs, string $scopes = 'read', string $website = ''): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->post($endpoint, [
            'client_name'   => $clientName,
            'redirect_uris' => $redirectURIs,
            'scopes'        => $scopes,
            'website'       => $website,
        ]);
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
     * @return array Application
     */
    public function verifyCredentials(): array
    {
        $endpoint = "{$this->endpoint}/verify_credentials";

        return $this->api->post($endpoint);
    }
}
