<?php

namespace Fundevogel\Mastodon\Traits;


trait Accounts
{
    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Accounts;
     */
    public function accounts(): \Fundevogel\Mastodon\Methods\Accounts\Accounts
    {
        return new \Fundevogel\Mastodon\Methods\Accounts\Accounts($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Bookmarks;
     */
    public function bookmarks(): \Fundevogel\Mastodon\Methods\Accounts\Bookmarks
    {
        return new \Fundevogel\Mastodon\Methods\Accounts\Bookmarks($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Favourites;
     */
    public function favourites(): \Fundevogel\Mastodon\Methods\Accounts\Favourites
    {
        return new Favourites($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Mutes;
     */
    public function mutes(): \Fundevogel\Mastodon\Methods\Accounts\Mutes
    {
        return new Mutes($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Blocks;
     */
    public function blocks(): \Fundevogel\Mastodon\Methods\Accounts\Blocks
    {
        return new Blocks($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\DomainBlocks;
     */
    public function domainBlocks(): \Fundevogel\Mastodon\Methods\Accounts\DomainBlocks
    {
        return new DomainBlocks($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Filters;
     */
    public function filters(): \Fundevogel\Mastodon\Methods\Accounts\Filters
    {
        return new Filters($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Reports;
     */
    public function reports(): \Fundevogel\Mastodon\Methods\Accounts\Reports
    {
        return new Reports($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\FollowRequests;
     */
    public function followRequests(): \Fundevogel\Mastodon\Methods\Accounts\FollowRequests
    {
        return new FollowRequests($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Endorsements;
     */
    public function endorsements(): \Fundevogel\Mastodon\Methods\Accounts\Endorsements
    {
        return new Endorsements($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\FeaturedTags;
     */
    public function featuredTags(): \Fundevogel\Mastodon\Methods\Accounts\FeaturedTags
    {
        return new FeaturedTags($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Preferences;
     */
    public function preferences(): \Fundevogel\Mastodon\Methods\Accounts\Preferences
    {
        return new Preferences($this);
    }


    /**
     * @return \Fundevogel\Mastodon\Methods\Accounts\Suggestions;
     */
    public function suggestions(): \Fundevogel\Mastodon\Methods\Accounts\Suggestions
    {
        return new Suggestions($this);
    }
}
