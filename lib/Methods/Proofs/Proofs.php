<?php

namespace Fundevogel\Mastodon\Methods\Proofs;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Proofs
 *
 * For use by identity providers
 */
class Proofs extends Method
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
