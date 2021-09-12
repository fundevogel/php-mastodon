<?php

namespace Fundevogel\Mastodon\Proofs;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Proofs
 *
 * For use by identity providers
 */
class Proofs extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'api/proofs';


    /**
     * View identity proof
     *
     * @return array Custom response defined by provider
     */
    public function get(): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->get($endpoint);
    }
}
