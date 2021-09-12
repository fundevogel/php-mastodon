<?php

namespace Fundevogel\Mastodon\Accounts;

use Fundevogel\Mastodon\ApiMethod;


/**
 * Class Reports
 *
 * Report problematic users to your moderators
 */
class Reports extends ApiMethod
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'reports';


    /**
     * Files a report
     *
     * @param string $accountID
     * @param array $statusIDs
     * @param string $comment
     * @param bool $forward
     * @return array
     */
    public function file(string $accountID = '', array $statusIDs = [], string $comment = '', bool $forward = true): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->post($endpoint, [
            'account_id' => $accountID,
            'status_ids' => $statusIDs,
            'comment'    => $comment,
            'forward'    => $forward,
        ]);
    }
}
