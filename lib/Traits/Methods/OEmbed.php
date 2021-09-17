<?php

namespace Fundevogel\Mastodon\Traits\Methods;


trait OEmbed
{
    /**
     * @return \Fundevogel\Mastodon\Methods\OEmbed\OEmbed;
     */
    public function oembed(): \Fundevogel\Mastodon\Methods\OEmbed\OEmbed
    {
        return new \Fundevogel\Mastodon\Methods\OEmbed\OEmbed($this);
    }
}
