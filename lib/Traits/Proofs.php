<?php

namespace Fundevogel\Mastodon\Traits;


trait Proofs
{
    /**
     * @return \Fundevogel\Mastodon\Methods\Proofs\Proofs;
     */
    public function proofs(): \Fundevogel\Mastodon\Methods\Proofs\Proofs
    {
        return new \Fundevogel\Mastodon\Methods\Proofs\Proofs($this);
    }
}
