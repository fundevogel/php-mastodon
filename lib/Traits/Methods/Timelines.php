<?php

namespace Fundevogel\Mastodon\Traits\Methods;


trait Timelines
{
    /**
     * @return \Fundevogel\Mastodon\Methods\Timelines\Timelines;
     */
    public function timelines(): \Fundevogel\Mastodon\Methods\Timelines\Timelines
    {
        return new \Fundevogel\Mastodon\Methods\Timelines\Timelines($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Timelines\Conversations;
     */
    public function conversations(): \Fundevogel\Mastodon\Methods\Timelines\Conversations
    {
        return new \Fundevogel\Mastodon\Methods\Timelines\Conversations($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Timelines\Lists;
     */
    public function lists(): \Fundevogel\Mastodon\Methods\Timelines\Lists
    {
        return new \Fundevogel\Mastodon\Methods\Timelines\Lists($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Timelines\Markers;
     */
    public function markers(): \Fundevogel\Mastodon\Methods\Timelines\Markers
    {
        return new \Fundevogel\Mastodon\Methods\Timelines\Markers($this);
    }
}
