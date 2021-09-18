<?php

namespace Fundevogel\Mastodon\Methods\Apps;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class OAuth
 *
 * Generate and manage OAuth tokens
 */
class OAuth extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'oauth';


    /**
     * Authorize a user
     *
     * Displays an authorization form to the user
     *
     * If approved, it will create and return an authorization code,
     * then redirect to the desired redirect_uri, or show the
     * authorization code if urn:ietf:wg:oauth:2.0:oob was requested.
     * The authorization code can be used while requesting a token
     * to obtain access to user-level methods.
     *
     * @param string $clientID Client ID, obtained during app registration
     * @param string $scope List of requested OAuth scopes, separated by spaces (or by pluses, if using query parameters). Must be a subset of scopes declared during app registration. If not provided, defaults to `read`
     * @param string $redirectURI Set a URI to redirect the user to. If this parameter is set to `urn:ietf:wg:oauth:2.0:oob` then the authorization code will be shown instead. Must match one of the redirect URIs declared during app registration
     * @param string $forceLogin Forces the user to re-login, which is necessary for authorizing with multiple accounts from the same instance
     * @param string $responseType Should be set equal to `code`
     *
     * @return array
     */
    public function authorize(string $clientID, string $scope = 'read', string $redirectURI = 'urn:ietf:wg:oauth:2.0:oob', bool $forceLogin = false, string $responseType = 'code'): array
    {
        $endpoint = "{$this->endpoint}/authorize";

        return $this->api->get($endpoint, [
            'client_id'     => $clientID,
            'scope'         => $scope,
            'redirect_uri'  => $redirectURI,
            'force_login'   => $forceLogin,
            'response_type' => $responseType,
        ]);
    }


    /**
     * Obtains a token
     *
     * Returns an access token, to be used during API calls that are not public
     *
     * @param string $clientID Client ID, obtained during app registration
     * @param string $clientSecret Client secret, obtained during app registration
     * @param string $grantType Set equal to `authorization_code` if `code` is provided in order to gain user-level access. Otherwise, set equal to `client_credentials` to obtain app-level access only
     * @param string $code A user authorization code, obtained via `/oauth/authorize`
     * @param string $scope List of requested OAuth scopes, separated by spaces. Must be a subset of scopes declared during app registration. If not provided, defaults to `read`
     * @param string $redirectURI Set a URI to redirect the user to. If this parameter is set to `urn:ietf:wg:oauth:2.0:oob` then the token will be shown instead. Must match one of the redirect URIs declared during app registration
     *
     * @return \Fundevogel\Mastodon\Entities\Token
     */
    public function token(string $clientID, string $clientSecret, string $grantType = 'client_credentials', string $code = '', string $scope = 'read', string $redirectURI = 'urn:ietf:wg:oauth:2.0:oob'): \Fundevogel\Mastodon\Entities\Token
    {
        $endpoint = "{$this->endpoint}/token";

        return new \Fundevogel\Mastodon\Entities\Token($this->api->post($endpoint, [
            'client_id'     => $clientID,
            'client_secret' => $clientSecret,
            'grant_type'    => $grantType,
            'scope'         => $scope,
            'code'          => $code,
            'redirect_uri'  => $redirectURI,
        ]));
    }


    /**
     * Revoke token
     *
     * Revoke an access token to make it no longer valid for use
     *
     * @param string $clientID Client ID, obtained during app registration
     * @param string $clientSecret Client secret, obtained during app registration
     * @param string $token The previously obtained token, to be invalidated
     *
     * @return array
     */
    public function revoke(string $clientID, string $clientSecret, string $token): array
    {
        $endpoint = "{$this->endpoint}/revoke";

        return $this->api->post($endpoint, [
            'client_id'     => $clientID,
            'client_secret' => $clientSecret,
            'token'         => $token,
        ]);
    }
}
