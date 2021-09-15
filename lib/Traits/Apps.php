<?php

namespace Fundevogel\Mastodon\Traits;


trait Apps
{
    /**
     * @return \Fundevogel\Mastodon\Methods\Apps\Apps;
     */
    public function apps(): \Fundevogel\Mastodon\Methods\Apps\Apps
    {
        return new \Fundevogel\Mastodon\Methods\Apps\Apps($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Apps\OAuth;
     */
    public function oauth(): \Fundevogel\Mastodon\Methods\Apps\OAuth
    {
        return new \Fundevogel\Mastodon\Methods\Apps\OAuth($this);
    }
}
