<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Accounts
 *
 * Methods concerning user accounts and related information
 */
class Accounts extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'accounts';


    /**
     * Account credentials
     */

    /**
     * Register an account
     *
     * Creates a user and account records
     *
     * Returns an account access token for the app that initiated
     * the request. The app should save this token for later, and
     * should wait for the user to confirm their account by clicking
     * a link in their email inbox.
     *
     * @param string $userName The desired username for the account
     * @param string $email The email address to be used for login
     * @param string $password The password to be used for login
     * @param bool $agreement Whether the user agrees to the local rules, terms, and policies. These should be presented to the user in order to allow them to consent before setting this parameter to `true`
     * @param string $locale The language of the confirmation email that will be sent
     * @param string $reason Text that will be reviewed by moderators if registrations require manual approval
     *
     * @return \Fundevogel\Mastodon\Entities\Token Token
     */
    public function register(string $userName, string $email, string $password, bool $agreement, string $locale, string $reason = ''): \Fundevogel\Mastodon\Entities\Token
    {
        $endpoint = "{$this->endpoint}";

        return new \Fundevogel\Mastodon\Entities\Token($api->post($endpoint, [
            'username'  => $userName,
            'email'     => $email,
            'password'  => $password,
            'agreement' => $agreement,
            'locale'    => $locale,
            'reason'    => $reason,
        ]));
    }


    /**
     * Verify account credentials
     *
     * Test to make sure that the user token works
     *
     * @return \Fundevogel\Mastodon\Entities\Account the user's own Account with Source
     */
    public function verifyCredentials(): \Fundevogel\Mastodon\Entities\Account
    {
        $endpoint = "{$this->endpoint}/verify_credentials";

        return new \Fundevogel\Mastodon\Entities\Account($this->api->get($endpoint));
    }


    /**
     * Update account credentials
     *
     * Update the user's display and preferences
     *
     * @param bool $discoverable Whether the account should be shown in the profile directory
     * @param bool $bot Whether the account has a bot flag
     * @param string $displayName The display name to use for the profile
     * @param string $note The account bio
     * @param string $avatar Avatar image encoded using `multipart/form-data`
     * @param string $header Header image encoded using `multipart/form-data`
     * @param bool $locked Whether manual approval of follow requests is required
     * @param string $sourcePrivacy Default post privacy for authored statuses
     * @param bool $sourceSensitive Whether to mark authored statuses as sensitive by default
     * @param string $sourceLanguage Default language to use for authored statuses (ISO 6391)
     * @param array $fieldAttributes Profile metadata `name` and `value` (by default, max 4 fields and 255 characters per property/value)
     *
     * @return \Fundevogel\Mastodon\Entities\Account the user's own Account with Source
     */
    public function updateCredentials(bool $discoverable = true, bool $bot = false, string $displayName = '', string $note, string $avatar = '', string $header = '', bool $locked = false, string $sourcePrivacy = '', bool $sourceSensitive = false, string $sourceLanguage = '', array $fieldAttributes = []): \Fundevogel\Mastodon\Entities\Account
    {
        $endpoint = "{$this->endpoint}/update_credentials";

        return new \Fundevogel\Mastodon\Entities\Account($this->api->patch($endpoint, [
            'discoverable'      => $discoverable,
            'bot'               => $bot,
            'display_name'      => $displayName,
            'note'              => $note,
            'avatar'            => $avatar,
            'header'            => $header,
            'locked'            => $locked,
            'source[privacy]'   => $sourcePrivacy,
            'source[sensitive]' => $sourceSensitive,
            'source[language]'  => $sourceLanguage,
            'field_attributes'  => $fieldAttributes
        ]));
    }


    /**
     * Retrieve information
     */

    /**
     * Account
     *
     * @param string $id The ID of the account in the database
     *
     * @return \Fundevogel\Mastodon\Entities\Account Account
     */
    public function get(string $id = ''): \Fundevogel\Mastodon\Entities\Account
    {
        # Fallback to current account
        if (empty($id)) {
            $id = $this->api->id();
        }

        $endpoint = "{$this->endpoint}/{$id}";

        return new \Fundevogel\Mastodon\Entities\Account($this->api->get($endpoint));
    }


    /**
     * Statuses
     *
     * Statuses posted to the given account
     *
     * @param string $id The ID of the account in the database
     * @param string $minID
     * @param bool $excludeReblogs
     * @param string $tagged
     *
     * @return array Array of Status
     */
    public function statuses(string $id = '', string $minID = '', bool $excludeReblogs = true, string $tagged = ''): array
    {
        # Fallback to current account
        if (empty($id)) {
            $id = $this->api->id();
        }

        $endpoint = "{$this->endpoint}/{$id}/statuses";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Status($data);
        }, $this->api->get($endpoint, [
           'min_id'          => $minID,
           'exclude_reblogs' => $excludeReblogs,
           'tagged'          => $tagged,
        ]));
    }


    /**
     * Followers
     *
     * Accounts which follow the given account, if network is not hidden by the account owner
     *
     * @param string $id The ID of the account in the database
     * @param string $maxID Return results older than ID
     * @param string $sinceID Return results newer than ID
     * @param int $limit Maximum number of results
     *
     * @return array Array of Account
     */
    public function followers(string $id = '', string $maxID = '', string $sinceID = '', int $limit = 20): array
    {
        # Fallback to current account
        if (empty($id)) {
            $id = $this->api->id();
        }

        $endpoint = "{$this->endpoint}/{$id}/followers";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Account($data);
        }, $this->api->get($endpoint, [
           'max_id'   => $maxID,
           'since_id' => $sinceID,
           'limit'    => $limit,
        ]));
    }


    /**
     * Following
     *
     * Accounts which the given account is following, if network is not hidden by the account owner
     *
     * @param string $id The ID of the account in the database
     * @param string $maxID
     * @param string $sinceID
     * @param int $limit
     *
     * @return array Array of Account
     */
    public function following(string $id = '', string $maxID = '', string $sinceID = '', int $limit = 40): array
    {
        # Fallback to current account
        if (empty($id)) {
            $id = $this->api->id();
        }

        $endpoint = "{$this->endpoint}/{$id}/following";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Account($data);
        }, $this->api->get($endpoint, [
           'max_id'   => $maxID,
           'since_id' => $sinceID,
           'limit'    => $limit,
        ]));
    }


    /**
     * Featured tags
     *
     * Tags featured by this account
     *
     * @param string $id The ID of the account in the database
     *
     * @return array Array of FeaturedTag
     */
    public function featuredTags(string $id = ''): array
    {
        # Fallback to current account
        if (empty($id)) {
            $id = $this->api->id();
        }

        $endpoint = "{$this->endpoint}/{$id}/featured_tags";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Account($data);
        }, $this->api->get($endpoint));
    }


    /**
     * Lists containing this account
     *
     * User lists that you have added this account to
     *
     * @param string $id The ID of the account in the database
     *
     * @return array Array of List
     */
    public function lists(string $id = ''): array
    {
        # Fallback to current account
        if (empty($id)) {
            $id = $this->api->id();
        }

        $endpoint = "{$this->endpoint}/{$id}/lists";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\ListEntity($data);
        }, $this->api->get($endpoint));
    }


    /**
     * Identity proofs
     *
     * @param string $id The ID of the account in the database
     *
     * @return array Array of IdentityProof
     */
    public function identityProofs(string $id = ''): array
    {
        # Fallback to current account
        if (empty($id)) {
            $id = $this->api->id();
        }

        $endpoint = "{$this->endpoint}/{$id}/identity_proofs";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\IdentityProof($data);
        }, $this->api->get($endpoint));
    }


    /**
     * Perform actions on an account
     */

    /**
     * Follow
     *
     * Follow the given account
     *
     * Can also be used to update whether to show reblogs or enable notifications.
     *
     * @param string $id The ID of the account in the database
     * @param bool $reblogs Receive this account's reblogs in home timeline?
     * @param bool $notify Receive notifications when this account posts a status?
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function follow(string $id, bool $reblogs = true, bool $notify = false): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/follow";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint, [
            'reblogs' => $reblogs,
            'notify'  => $notify,
        ]));
    }


    /**
     * Unfollow
     *
     * Unfollow the given account
     *
     * @param string $id The ID of the account in the database
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function unfollow(string $id): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/unfollow";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint));
    }


    /**
     * Block
     *
     * Block the given account
     *
     * Clients should filter statuses from this account if received
     * (e.g. due to a boost in the Home timeline).
     *
     * @param string $id The ID of the account in the database
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function block(string $id): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/block";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint));
    }


    /**
     * Unblock
     *
     * Unblock the given account
     *
     * @param string $id The ID of the account in the database
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function unblock(string $id): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/unblock";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint));
    }


    /**
     * Mute
     *
     * Mute the given account
     *
     * Clients should filter statuses and notifications from this account,
     * if received (e.g. due to a boost in the Home timeline).
     *
     * @param string $id The ID of the account in the database
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function mute(string $id): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/mute";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint));
    }


    /**
     * Unmute
     *
     * Unmute the given account
     *
     * @param string $id The ID of the account in the database
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function unmute(string $id): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/unmute";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint));
    }


    /**
     * Features account on profile
     *
     * Add the given account to the user's featured profiles
     *
     * Featured profiles are currently shown on the user's own public profile.
     *
     * @param string $id The ID of the account in the database
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function pin(string $id): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/pin";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint));
    }


    /**
     * Unfeatures account on profile
     *
     * Remove the given account from the user's featured profiles
     *
     * @param string $id The ID of the account in the database
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function unpin(string $id): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/unpin";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint));
    }


    /**
     * User note
     *
     * Sets a private note on a user
     *
     * @param string $id The ID of the account in the database
     * @param string $comment The comment to be set on that user. Provide an empty string or leave out this parameter to clear the currently set note
     *
     * @return \Fundevogel\Mastodon\Entities\Relationship Relationship
     */
    public function note(string $id, string $comment = ''): \Fundevogel\Mastodon\Entities\Relationship
    {
        $endpoint = "{$this->endpoint}/{$id}/note";

        return new \Fundevogel\Mastodon\Entities\Relationship($this->api->post($endpoint, [
            'comment' => $comment,
        ]));
    }


    /**
     * General account actions
     */

    /**
     * Check relationships to other accounts
     *
     * Find out whether a given account is followed, blocked, muted, etc
     *
     * @param array $id Array of account IDs to check
     *
     * @return array Array of Relationship
     */
    public function relationships(array $id): array
    {
        $endpoint = "{$this->endpoint}/relationships";

        return array_map(function ($data) {
            return new \Fundevogel\Mastodon\Entities\Relationship($data);
        }, $this->api->get($endpoint, [
            'id' => $id,
        ]));
    }


    /**
     * Search for matching accounts
     *
     * Search for matching accounts by username or display name
     *
     * @param string $q What to search for
     * @param int $limit Maximum number of results
     * @param string $resolve Attempt WebFinger lookup. Use this when `q` is an exact address
     * @param bool $following Only who the user is following
     *
     * @return array Array of Account
     */
    public function search(string $q, int $limit = 40, string $resolve = '', bool $following = false): array
    {
        $endpoint = "{$this->endpoint}/search";

        return array_map(function($data) {
            return new \Fundevogel\Mastodon\Entities\Account($data);
        }, $this->api->get($endpoint, [
            'q'         => $q,
            'limit'     => $limit,
            'resolve'   => $resolve,
            'following' => $following,
        ]));
    }
}
