<?php

namespace Fundevogel\Mastodon\Traits;


trait Statuses
{

    /**
     * @return \Fundevogel\Mastodon\Methods\Statuses\Statuses;
     */
    public function statuses(): \Fundevogel\Mastodon\Methods\Statuses\Statuses
    {
        return new \Fundevogel\Mastodon\Methods\Statuses\Statuses($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Statuses\Media;
     */
    public function media(): \Fundevogel\Mastodon\Methods\Statuses\Media
    {
        return new \Fundevogel\Mastodon\Methods\Statuses\Media($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Statuses\Polls;
     */
    public function polls(): \Fundevogel\Mastodon\Methods\Statuses\Polls
    {
        return new \Fundevogel\Mastodon\Methods\Statuses\Polls($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Statuses\ScheduledStatuses;
     */
    public function scheduledStatuses(): \Fundevogel\Mastodon\Methods\Statuses\ScheduledStatuses
    {
        return new \Fundevogel\Mastodon\Methods\Statuses\ScheduledStatuses($this);
    }
}
