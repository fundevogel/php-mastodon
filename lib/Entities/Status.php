<?php

namespace Fundevogel\Mastodon\Entities;


/**
 * Class Status
 */
class Status
{
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
     * @return bool Whether media downloads were successful
     */
    public function downloadMedia(string $directory, bool $overwrite = false): bool
    {
        try {
            foreach ($this->data['media_attachments'] as $media) {
                # Download files
                # (1) Original file
                $this->download($media['url'], $directory, $overwrite);

                # (2) Preview image
                $this->download($media['preview_url'], $directory, 'thumb_', $overwrite);
            }

        } catch (\Exception $e) {}

        return false;
    }
}
