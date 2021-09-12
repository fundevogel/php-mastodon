# php-mastodon
[![Release](https://img.shields.io/github/release/Fundevogel/php-mastodon.svg)](https://github.com/Fundevogel/php-mastodon/releases) [![License](https://img.shields.io/github/license/Fundevogel/php-mastodon.svg)](https://github.com/Fundevogel/php-mastodon/blob/master/LICENSE) [![Issues](https://img.shields.io/github/issues/Fundevogel/php-mastodon.svg)](https://github.com/Fundevogel/php-mastodon/issues) [![Status](https://travis-ci.org/Fundevogel/php-mastodon.svg?branch=master)](https://travis-ci.org/Fundevogel/php-mastodon)

A small PHP library for interacting with [Mastodon](https://en.wikipedia.org/wiki/Mastodon_(software))'s REST API. Its documentation can be found [here](https://docs.joinmastodon.org/client/intro).

**Note**: Before you get started, be sure to [create an application](https://docs.joinmastodon.org/client/token) (under "Development" in your profile settings) first.

## Getting started

Install this package with [Composer](https://getcomposer.org):

```text
composer require fundevogel/php-mastodon
```

An example implementation could look something like this:

```php
<?php

require_once('vendor/autoload.php');

use Fundevogel\Mastodon\Api;

$api = new Api();

# Set instance (defaults to 'mastodon.social')
$api->instance = 'freiburg.social';

# Generate access token via ..
# (1) OAuth call
$api->accessToken = $api->oauth()->token('qRgD4PfAaLtGdTD8AqB9xjV9HhHNMpmQfAwduIDoO-4', 'zpCZc082NnKZMOtjmPrIkLnnqXnOssa-SQU8bxjJsIo')['access_token'];

# (2) .. app creation (create an app, get one `access_token` for free!)
$api->accessToken = 'ur-t0t4lly-s3cr3t-p4ssw@rd';

# Fetch statuses of given account
foreach ($api->accounts()->statuses('106612343490709443') as $status) {
    echo $status['content'];
}

# Fetch followers
foreach ($api->accounts()->followers('106612343490709443') as $status) {
    echo $follower['display_name'];
}

# View your timelines
$timelines = $api->timelines();

# (1) Public timeline
var_dump($timelines->public());

# (2) Home timeline (= accounts you are following)
var_dump($timelines->home());

# Fetch information about your instance
var_dump($api->instance()->get());


# ... enjoy playing with Mastodon's API!
```


## Roadmap

- [ ] Add tests
- [ ] Return API entities as individual classes
- [ ] Implement missing API methods:
    - timelines/streaming
    - notifications/push
    - search
    - admin


**Happy coding!**
