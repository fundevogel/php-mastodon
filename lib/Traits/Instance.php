<?php

namespace Fundevogel\Mastodon\Traits;


trait Instance
{
    /**
     * @return \Fundevogel\Mastodon\Methods\Instance\Instance;
     */
    public function instance(): \Fundevogel\Mastodon\Methods\Instance\Instance
    {
        return new \Fundevogel\Mastodon\Methods\Instance\Instance($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Instance\Trends;
     */
    public function trends(): \Fundevogel\Mastodon\Methods\Instance\Trends
    {
        return new \Fundevogel\Mastodon\Methods\Instance\Trends($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Instance\Directory;
     */
    public function directory(): \Fundevogel\Mastodon\Methods\Instance\Directory
    {
        return new \Fundevogel\Mastodon\Methods\Instance\Directory($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Instance\CustomEmojis;
     */
    public function customEmojis(): \Fundevogel\Mastodon\Methods\Instance\CustomEmojis
    {
        return new \Fundevogel\Mastodon\Methods\Instance\CustomEmojis($this);
    }
}
