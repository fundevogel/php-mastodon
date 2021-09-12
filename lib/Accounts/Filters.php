<?php

namespace Fundevogel\Mastodon\Accounts;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Filters
 *
 * Create and manage filters
 */
class Filters extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'filters';


    /**
     * View all filters
     *
     * @return array Filter
     */
    public function all(): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint);
    }


    /**
     * View a single filter
     *
     * @param string $id
     *
     * @return array Filter
     */
    public function get(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->get($endpoint);
    }


    /**
     * Create a filter
     *
     * @param string $phrase Text to be filtered
     * @param array $context Array of enumerable strings `home`, `notifications`, `public`, `thread`. At least one context must be specified
     * @param bool $irreversible Should the server irreversibly drop matching entities from home and notifications?
     * @param bool $wholeWord Consider word boundaries?
     * @param int $expiresIn Number of seconds from now the filter should expire. Otherwise, null for a filter that doesn't expire
     *
     * @return array Filter
     */
    public function create(string $phrase, array $context, bool $irreversible = false, bool $wholeWord = true, int $expiresIn = 0): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->post($endpoint, [
            'phrase'       => $phrase,
            'context'      => $context,
            'irreversible' => $irreversible,
            'whole_word'   => $wholeWord,
            'expires_in'   => $expiresIn,
        ]);
    }


    /**
     * Update a filter
     *
     * @param string $id ID of the filter in the database
     * @param string $phrase Text to be filtered
     * @param array $context Array of enumerable strings `home`, `notifications`, `public`, `thread`. At least one context must be specified
     * @param bool $irreversible Should the server irreversibly drop matching entities from home and notifications?
     * @param bool $wholeWord Consider word boundaries?
     * @param int $expiresIn Number of seconds from now the filter should expire. Otherwise, null for a filter that doesn't expire
     *
     * @return array Filter
     */
    public function update(string $id, string $phrase, array $context, bool $irreversible, bool $wholeWord, int $expiresIn): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->put($endpoint);
    }


    /**
     * Remove a filter
     *
     * @param string $id ID of the filter in the database
     *
     * @return array Filter
     */
    public function remove(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->delete($endpoint);
    }
}
