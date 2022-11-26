# php-mastodon
[![Release](https://img.shields.io/github/release/Fundevogel/php-mastodon.svg)](https://github.com/Fundevogel/php-mastodon/releases) [![License](https://img.shields.io/github/license/Fundevogel/php-mastodon.svg)](https://github.com/Fundevogel/php-mastodon/blob/master/LICENSE) [![Issues](https://img.shields.io/github/issues/Fundevogel/php-mastodon.svg)](https://github.com/Fundevogel/php-mastodon/issues) [![Status](https://travis-ci.org/Fundevogel/php-mastodon.svg?branch=master)](https://travis-ci.org/Fundevogel/php-mastodon)

A small PHP library for interacting with [Mastodon](https://en.wikipedia.org/wiki/Mastodon_(software))'s REST API. Its documentation can be found [here](https://docs.joinmastodon.org/client/intro).

**Note**: Before you get started, be sure to [create an application](https://docs.joinmastodon.org/client/token) (under "Development" in your profile settings) first.


## Getting started

Install this package with [Composer](https://getcomposer.org):

```text
composer require mrwilsonsworkshop/php-mastodon
```

To get an idea how you could implement this, have a look at these examples:

```php
<?php

require_once('vendor/autoload.php');

use MrWilsonsWorkshop\Mastodon\Api;

# Initialize Api for given instance (defaults to 'mastodon.social')
$api = new Api('freiburg.social');

# Generate access token via ..
# (1) .. OAuth call or ..
$api->accessToken = $api->oauth()->token('cl13nt_1d', 'cl13nt_s3cr3t')['access_token'];

# (2) .. app creation (create an app, get one `access_token` for free!)
$api->accessToken = 'ur-t0t4lly-s3cr3t-p4ssw@rd';

# If you want to obtain an authorization code, and want to know where to get one ..
$url = $api->getAuthURL('cl13nt_1d');

# .. but you might want to provide what you have & use the login helper
$api->logIn();

# This helper takes the authorization code as parameter - however,
# if you provided client key / secret / access token,
# it will attempt to provide whatever access level is possible

# Fetch statuses of given account
foreach ($api->accounts()->statuses('106612343490709443') as $status) {
    echo $status->content();
}

# Note: In case you obtained login-level access, you may omit the ID parameter, which gives back your own account's statuses, like so:
foreach ($api->accounts()->statuses() as $status) {
    echo $status->content();
}

# Fetch followers
foreach ($api->accounts()->followers('106612343490709443') as $follower) {
    echo $follower->displayName();
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

**Note:** In most cases, using `$api->logIn()` will be enough. You may then view other people's statuses, etc as well as your own by providing your account ID as parameter as shown above.


### .. but I need more docs!

First, have a look at [the docs](https://docs.joinmastodon.org).

Now, all API methods match their URL counterparts:

- `mastodon.example/api/v1/accounts/:id` becomes `$api->accounts()->get($id)`
- `mastodon.example/api/v1/accounts/:id/statuses` becomes `$api->accounts()->statuses($id)`
- `mastodon.example/api/v1/timelines/home` becomes `$api->timelines()->home()`
- `mastodon.example/api/v1/statuses/:id` becomes `$api->statuses()->get($id)`

.. same goes for the resulting API entities you get back. For example, the [`Status`](https://docs.joinmastodon.org/entities/status) entity methods match their array counterparts as found in the docs (only camelcased):

- `id` may be accessed with `$status->id()`
- `created_at` may be accessed with `$status->createdAt()`
- `account` may be accessed with `$status->account()` (which in turn gives an [`Account`](https://docs.joinmastodon.org/entities/account) entity)


## Roadmap

- [ ] Add tests
- [x] Add authentication helpers
- [x] Return API entities as individual classes
- [ ] Add missing API methods:
    - timelines/streaming
    - notifications/push
    - search
    - admin
- [ ] Add missing API entities:
    - admin/account
    - admin/report
- [ ] Update empty API entities:
    - error
    - pushsubscription
    - report
    - scheduledstatus


**Happy coding!**
