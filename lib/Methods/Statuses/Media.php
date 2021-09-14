<?php

namespace Fundevogel\Mastodon\Methods\Statuses;

use Fundevogel\Mastodon\Methods\Method;


/**
 * Class Media
 *
 * Attach media to authored statuses
 */
class Media extends Method
{
    /**
     * API endpoint
     *
     * @var string
     */
    private $endpoint = 'media';


    /**
     * Upload media as attachment
     *
     * Creates an attachment to be used with a new status
     *
     * @param object $file The file to be attached, using `multipart/form-data`
     * @param object $thumbnail The custom thumbnail of the media to be attached, using `multipart/form-data`
     * @param string $description A plain-text description of the media, for accessibility purposes
     * @param string $focus Two floating points (x,y), comma-delimited, ranging from -1.0 to 1.0
     *
     * @return array Attachment
     */
    public function upload(object $file, object $thumbnail, string $description = '', string $focus = ''): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->post($endpoint, [
            'file'        => $file,
            'thumbnail'   => $thumbnail,
            'description' => $description,
            'focus'       => $focus,
        ]);
    }


    /**
     * Get attachment
     *
     * Get an Attachment, before it is attached to a status and posted, but after it is accepted for processing
     *
     * @param string $id The ID of the Attachment entity
     *
     * @return array Attachment
     */
    public function get(string $id): array
    {
        $endpoint = "{$this->endpoint}/{$id}";

        return $this->api->get($endpoint);
    }


    /**
     * Update attachment
     *
     * Update an Attachment, before it is attached to a status and posted
     *
     * @param string $id The ID of the Attachment entity to be updated
     * @param string $file The file to be attached, using `multipart/form-data`
     * @param string $thumbnail The custom thumbnail of the media to be attached, using `multipart/form-data`
     * @param string $description A plain-text description of the media, for accessibility purposes
     * @param string $focus Two floating points (x,y), comma-delimited, ranging from -1.0 to 1.0
     *
     * @return array Attachment
     */
    public function update(string $id, string $file = '', string $thumbnail = '', string $description = '', string $focus = ''): array
    {
        $endpoint = "{$this->endpoint}";

        return $this->api->put($endpoint, [
            'file'        => $file,
            'thumbnail'   => $thumbnail,
            'description' => $description,
            'focus'       => $focus,
        ]);
    }
}
