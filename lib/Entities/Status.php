<?php

namespace Fundevogel\Mastodon\Entities;


/**
 * Class Status
 */
class Status
{
    /**
     * Enable media downloads
     */
    use \Fundevogel\Mastodon\Traits\Downloader;


    /**
     * Raw data
     *
     * @var array
     */
    public $data;


    /**
     * Constructor
     */
    public function __construct(array $data)
    {
        # Store raw data
        $this->data = $data;
    }


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
                # Download files
                # (1) Original file
                $original = basename($media['url']);

                if ($this->download($media['url'], $directory, $original, $overwrite)) {
                    $downloads[] = $original;
                }

                # (2) Preview image
                $thumb = 'thumb_' . basename($media['preview_url']);

                if ($this->download($media['preview_url'], $directory, $thumb, $overwrite)) {
                    $downloads[] = $thumb;
                }

            } catch (\Exception $e) {}
        }

        return $downloads;
    }
}
