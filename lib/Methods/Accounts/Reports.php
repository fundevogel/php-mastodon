<?php

namespace Fundevogel\Mastodon\Methods\Accounts;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Reports
 *
 * Report problematic users to your moderators
 */
class Reports extends Method
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
