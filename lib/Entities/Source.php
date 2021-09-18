<?php

namespace Fundevogel\Mastodon\Entities;

use Fundevogel\Mastodon\Entities\Entity;


/**
 * Class Source
 *
 * Represents display or publishing preferences of user's own account
 *
 * Returned as an additional entity when verifying and updated credentials,
 * as an attribute of Account.
 *
 * @see https://docs.joinmastodon.org/entities/source
 */
class Source extends Entity {}
