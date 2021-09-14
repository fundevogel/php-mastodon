<?php

namespace Fundevogel\Mastodon\Methods\Timelines;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Lists
 *
 * View and manage lists
 */
class Lists extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'lists';


    /**
     * Show user's lists
     *
     * Fetch all lists that the user owns
     *
     * @return array Array of List
     */
    public function all(): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint);
    }


    /**
     * Show a single list
     *
     * Fetch the list with the given ID
     *
     * Used for verifying the title of a list, and which replies to show within that list.
     *
     * @param string $id ID of the list in the database
     *
     * @return array List
     */
    public function get(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->get($endpoint);
    }


    /**
     * Create a list
     *
     * Create a new list
     *
     * @param string $title The title of the list to be created
     * @param string $repliesPolicy Enumerable oneOf `followed`, `list` or `none`
     *
     * @return array List
     */
    public function create(string $title, string $repliesPolicy = 'list'): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->post($endpoint, [
            'title'          => $title,
            'replies_policy' => $repliesPolicy,
        ]);
    }


    /**
     * Update a list
     *
     * Change the title of a list, or which replies to show
     *
     * @param string $id ID of the list in the database
     * @param string $title The title of the list to be created
     * @param string $repliesPolicy Enumerable oneOf `followed`, `list` or `none`
     *
     * @return array List
     */
    public function update(string $id, string $title = '', string $repliesPolicy = 'list'): array
    {
        $endpoint = "{$this->endpoint}/{$id}/read";

        return $this->api->put($endpoint, [
            'title'          => $title,
            'replies_policy' => $repliesPolicy
        ]);
    }


    /**
     * Accounts in a list
     */

    /**
     * View accounts in list
     *
     * @param string $id ID of the list in the database
     * @param string $maxID
     * @param string $sinceID
     * @param int $limit
     *
     * @return array Array of Account
     */
    public function accounts(string $id, string $maxID = '', string $sinceID = '', int $limit = 20): array
    {
        $endpoint = "{$this->endpoint}/{$id}/accounts";

        return $this->api->get($endpoint, [
            'max_id'   => $maxID,
            'since_id' => $sinceID,
            'limit'    => $limit,
        ]);
    }


    /**
     * Add accounts to list
     *
     * Add accounts to the given list
     *
     * Note that the user must be following these accounts.
     *
     * @param string $id ID of the list in the database
     * @param array $accountIDs Array of account IDs to add to the list
     *
     * @return array empty object
     */
    public function addAccounts(string $id, array $accountIDs): array
    {
        $endpoint = "{$this->endpoint}/{$id}/accounts";

        return $this->api->post($endpoint, [
            'account_ids' => $accountIDs,
        ]);
    }


    /**
     * Remove accounts from list
     *
     * Remove accounts from the given list
     *
     * @param string $id ID of the list in the database
     * @param array $accountIDs Array of account IDs to remove from the list
     *
     * @return array empty object
     */
    public function removeAccounts(string $id, array $accountIDs): array
    {
        $endpoint = "{$this->endpoint}/{$id}/accounts";

        return $this->api->delete($endpoint, [
            'account_ids' => $accountIDs,
        ]);
    }

}
