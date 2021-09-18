<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Status
 *
 * Represents a status posted by an account
 *
 * @see https://docs.joinmastodon.org/entities/status
 */
class Status extends Entity
{
    /**
     * Enable media downloads
     */
    use \Fundevogel\Mastodon\Traits\Downloader;


    /**
     * Downloads media attachments
     *
     * @param string $directory Download directory
     * @param bool $overwrite Whether existing file should be overwritten
     *
     * @return array Names of all downloaded files
     */
    public function downloadMedia(string $directory, bool $overwrite = false): array
    {
        # Log downloaded files
        $downloads = [];

        # Loop over media attachments
        foreach ($this->data['media_attachments'] as $media) {
            try {
                # Download original files
                $file = basename($media['url']);

                if ($this->download($media['url'], $directory, $file, $overwrite)) {
                    $downloads[] = $file;
                }

            } catch (\Exception $e) {}
        }

        return $downloads;
    }
}
