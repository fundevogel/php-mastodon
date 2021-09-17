<?php

namespace Fundevogel\Mastodon\Traits;


/**
 * Trait Downloader
 *
 * Provides ability to download external files
 */

trait Downloader
{
    /**
     * User-Agent used when downloading file
     *
     * @var string
     */
    public $userAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0';


    /**
     * Downloads file from external source
     *
     * @param string $url Target file URL
     * @param string $directory Download directory
     * @param string $prefix Filename prefix
     * @param bool $overwrite Whether existing file should be overwritten
     *
     * @return bool Whether download was successful
     */
    private function download(string $url, string $directory, string $prefix = '', bool $overwrite = false): bool
    {
        # Build path to file
        $file = $directory . '/' . $prefix . basename($url);

        # Skip if file exists & overwriting it is disabled
        if (file_exists($file) && !$overwrite) {
            return true;
        }

        # Otherwise, create directory if necessary
        if (!file_exists($directory)) {
            mkdir(dirname($file), 0755, true);
        }

        # Store success rate
        $success = false;

        # Create file handle
        if ($handle = fopen($file, 'w')) {
            # Initialize HTTP handler
            $client = new \GuzzleHttp\Client();

            try {
                # Download file
                $response = $client->get($url, ['sink' => $handle]);
                $success = true;

            } catch (\GuzzleHttp\Exception\ClientException $e) {}
        }

        return $success;
    }
}
